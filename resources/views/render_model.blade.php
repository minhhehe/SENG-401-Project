<?php
	$loadFull = ($renderedModel->file_name == "ferrari.glb");
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>CRAP</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

	<style>
	body {
		/* font-family: Monospace; */
		background-color: #000;
		color: #000;
		margin: 0px;
		overflow: hidden;
	}
	#info {
		position: absolute;
		top: 80px;
		width: 100%;
		text-align: center;
		z-index: 100;
	}
	#info a {
		color: blue;
		font-weight: bold;
	}
	 .topRight {
		 position: absolute;
		   top: 8px;
		   right: 16px;
		   font-size: 18px;
	 }

	</style>
</head>

<body>
	<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
		<div class="container">
			<a class="navbar-brand" href="{{ url('/') }}">
				<!-- {{ config('app.name', 'Laravel') }} -->
				CADA Realistic Automotive Project
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<!-- Left Side Of Navbar -->
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="{{ url('/select') }}">Select a Model</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ url('/render_model/1') }}">Colour</a>
					</li>
				</ul>

				<!-- Right Side Of Navbar -->
				<ul class="navbar-nav ml-auto">
					<!-- Authentication Links -->
					@guest
						<li class="nav-item">
							<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
						</li>
						@if (Route::has('register'))
							<li class="nav-item">
								<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
							</li>
						@endif
					@else
						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{ url('/home') }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
								{{ Auth::user()->fname }} {{ Auth::user()->lname}} <span class="caret"></span>
							</a>

							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ route('logout') }}"
								   onclick="event.preventDefault();
												 document.getElementById('logout-form').submit();">
									{{ __('Logout') }}
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
							</div>
						</li>
					@endguest
				</ul>
			</div>
		</div>
	</nav>

	<div id="info">
		<span>Rims / Trim: <input id="rim-mat" type="color"></span>
		<span>Glass: <input id="glass-mat" type="color"></span>

		<span>Custom Body: <input type='color' id ='custom-body-mat'/>

		</span>
		<span>Custom Interior: <input id="custom-interior-mat" type="color"></span>
		<br><br>
		<span>Driver camera: <input type="checkbox" id="camera-toggle"></span>

		<button class="btn btn-secondary topRight" onclick="document.location.href='{{ url('/submitted') }}'"> Submit </button>
	</div>

	<div id="container"></div>

	<script src="{{ asset('js/three.min.js') }}"></script>

	<script src="{{ asset('js/loaders/DRACOLoader.js') }}"></script>
	<script src="{{ asset('js/loaders/GLTFLoader.js') }}"></script>

	<script src="{{ asset('js/pmrem/PMREMGenerator.js') }}"></script>
	<script src="{{ asset('js/pmrem/PMREMCubeUVPacker.js') }}"></script>

	<script src="{{ asset('js/Car.js') }}"></script>

	<script src="{{ asset('js/WebGL.js') }}"></script>
	<script src="{{ asset('js/libs/stats.min.js') }}"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src='{{ asset('js/spectrum.js') }}'></script>
	<link rel='stylesheet' href='{{ asset('css/spectrum.css') }}' />
	<audio id="audio" src='{{ asset('temp/HOTPINK.mp3') }}' preload="auto"></audio>


	<script>

	if ( WEBGL.isWebGLAvailable() === false ) {

		document.body.appendChild( WEBGL.getWebGLErrorMessage() );

	}

	var camera, scene, renderer, stats, carModel, materialsLib, envMap;

	var rimMatCustom = $('#rim-mat');
	var customBodyMatSelect = $('#custom-body-mat');
	var customInteriorMatSelect = $('#custom-interior-mat');
	var customGlassMat = $('#glass-mat' );

	var customBodyColour = "#fc1900";
	var customInteriorColour = "#000000";
	var customRimColour = "#fc1900";
	var customGlassColour = "#ffffff";

	var followCamera = document.getElementById( 'camera-toggle' );



	var clock = new THREE.Clock();
	var car = new THREE.Car();
	car.turningRadius = 75;

	var carParts = {
		body: [],
		interior: [],
		rims:[],
		glass: [],
	};

	var damping = 5.0;
	var distance = 5;
	var cameraTarget = new THREE.Vector3();

	function init() {

		var container = document.getElementById( 'container' );

		camera = new THREE.PerspectiveCamera( 50, window.innerWidth / window.innerHeight, 0.1, 200 );
		camera.position.set( 3.25, 2.0, -5 );
		camera.lookAt( 0, 0.5, 0 );

		scene = new THREE.Scene();
		scene.fog = new THREE.Fog( 0xd7cbb1, 1, 80 );

		var urls = [ 'px.jpg', 'nx.jpg', 'py.jpg', 'ny.jpg', 'pz.jpg', 'nz.jpg' ];
		var loader = new THREE.CubeTextureLoader().setPath( '{{ asset('textures/cube/skyboxsun25deg') }}/');
		loader.load( urls, function ( texture ) {

			scene.background = texture;

			var pmremGenerator = new THREE.PMREMGenerator( texture );
			pmremGenerator.update( renderer );

			var pmremCubeUVPacker = new THREE.PMREMCubeUVPacker( pmremGenerator.cubeLods );
			pmremCubeUVPacker.update( renderer );

			envMap = pmremCubeUVPacker.CubeUVRenderTarget.texture;

			pmremGenerator.dispose();
			pmremCubeUVPacker.dispose();


			initCar();
			initMaterialSelectionMenus();

		} );

		var ground = new THREE.Mesh(
			new THREE.PlaneBufferGeometry( 2400, 2400 ),
			new THREE.ShadowMaterial( { color: 0x000000, opacity: 0.15, depthWrite: false }
			) );
			ground.rotation.x = - Math.PI / 2;
			ground.receiveShadow = true;
			ground.renderOrder = 1;
			scene.add( ground );

			var grid = new THREE.GridHelper( 400, 40, 0x000000, 0x000000 );
			grid.material.opacity = 0.2;
			grid.material.depthWrite = false;
			grid.material.transparent = true;
			scene.add( grid );

			renderer = new THREE.WebGLRenderer( { antialias: true } );
			renderer.gammaOutput = true;
			renderer.setPixelRatio( window.devicePixelRatio );
			renderer.setSize( window.innerWidth, window.innerHeight );

			container.appendChild( renderer.domElement );

			stats = new Stats();
			container.appendChild( stats.dom );

			window.addEventListener( 'resize', onWindowResize, false );

			renderer.setAnimationLoop( function() {

				update();

				renderer.render( scene, camera );

			} );

		}

		function initCar() {

			THREE.DRACOLoader.setDecoderPath( '{{ asset('js/libs/draco/gltf') }}/' );

			var loader = new THREE.GLTFLoader();
			loader.setDRACOLoader( new THREE.DRACOLoader() );
			loader.load( '{{ asset("storage/$renderedModel->file_name") }}', function( gltf ) { // ------------- TODO Redirect to dynamic path instead of ferrari ---------------

				carModel = gltf.scene.children[ 0 ];

				@if ($loadFull)
				car.setModel( carModel );
				@endif

				carModel.traverse( function ( child ) {

					if ( child.isMesh  ) {
						child.material.envMap = envMap;
					}

				} );

				@if ($loadFull)
				// shadow
				var texture = new THREE.TextureLoader().load( '{{ asset('storage/ferrari_ao.png') }}' ); // ------------- TODO Redirect to dynamic path instead of ferrari ---------------
				var shadow = new THREE.Mesh(
					new THREE.PlaneBufferGeometry( 0.655 * 4, 1.3 * 4 ).rotateX( - Math.PI / 2 ),
					new THREE.MeshBasicMaterial( { map: texture, opacity: 0.8, transparent: true } )
				);
				shadow.renderOrder = 2;
				carModel.add( shadow );
				@endif

				scene.add( carModel );

				@if ($loadFull)
				carParts.body.push(carModel.getObjectByName('body'));

				carParts.interior.push(carModel.getObjectByName('leather'));

				carParts.rims.push(
					carModel.getObjectByName( 'rim_fl' ),
					carModel.getObjectByName( 'rim_fr' ),
					carModel.getObjectByName( 'rim_rr' ),
					carModel.getObjectByName( 'rim_rl' ),
					carModel.getObjectByName( 'trim' ),
				);

				carParts.glass.push(
					carModel.getObjectByName( 'glass' ),
				);

				updateMaterials();
				@endif
			});

		}
		function initMaterialSelectionMenus() {

			$("#custom-body-mat").spectrum({
				flat: false,
				showInitial: true,
				showValue: true,
				showPalette: true,

				palette:[   ['#00000', '#ffffff'],
				['#676a6b', '#a2a9ab'],
				['#fc0000', '#00B1FC'],
				['#001203', '#FF69B4']

			],


			color: customBodyColour,

			change: function(color) {
				customBodyColour = color.toHexString();
				updateMaterials();
			},

			move: function(color) {
				customBodyColour = color.toHexString();
				updateMaterials();
			},

			hide: function(colour) {
				if(customBodyColour == "#ff69b4"){
					document.getElementById('audio').play();
				} else {
					document.getElementById('audio').pause();
				}
			}

		});

		$("#custom-interior-mat").spectrum({
			flat: false,
			showInitial: true,
			showValue: true,
			showPalette: true,

			palette:[
				['#000000', '#ffffff'],
				['#f5f5dc', '#d9b382'],
				['#fc0000', '#00B1FC'],
				['#696969', '#FF69B4']

			],
			color: customInteriorColour,

			change: function(color) {
				customInteriorColour = color.toHexString();
				console.log(customInteriorColour);
				updateMaterials();
			},

			move: function(color) {
				customInteriorColour = color.toHexString();
				console.log(customInteriorColour);
				updateMaterials();
			}
		});


		$("#rim-mat").spectrum({
			flat: false,
			showInitial: true,
			showValue: true,
			showPalette: true,

			palette:[
				['#000000', '#ffffff'],
				['#f5f5dc', '#d9b382'],
				['#fc0000', '#00B1FC'],
				['#696969', '#FF69B4']

			],
			color: customRimColour,

			change: function(color) {
				customRimColour = color.toHexString();
				console.log(customRimColour);
				updateMaterials();
			},

			move: function(color) {
				customRimColour = color.toHexString();
				console.log(customRimColour);
				updateMaterials();
			}
		});



		$("#glass-mat").spectrum({
			flat: false,
			showInitial: true,
			showValue: true,
			showPalette: true,

			palette:[
				['#000000', '#ffffff'],
				['#f5f5dc', '#d9b382'],
				['#fc0000', '#00B1FC'],
				['#696969', '#FF69B4']

			],
			color: customGlassColour,

			change: function(color) {
				customGlassColour = color.toHexString();
				console.log(customGlassColour);
				updateMaterials();
			},

			move: function(color) {
				customGlassColour = color.toHexString();
				console.log(customGlassColour);
				updateMaterials();
			}
		});
	}

	// set materials to the current values of the selection menus
	function updateMaterials() {

		var glassMat = new THREE.MeshStandardMaterial( { color: customGlassColour,  envMap: envMap, metalness: 1, roughness: 0, opacity: 0.2, transparent: true, premultipliedAlpha: true, name: 'customGlass' } );
		var customBodyMat = new THREE.MeshStandardMaterial( { color: customBodyColour, envMap: envMap, metalness: 0.9, roughness: 0.2, name: 'customBody' } );
		var customInteriorMat = new THREE.MeshStandardMaterial( { color: customInteriorColour, envMap: envMap, metalness: 0.3, roughness: 0.2, name: 'customInterior' } );
		var rimMat = new THREE.MeshStandardMaterial( { color: customRimColour, envMap: envMap, metalness: 0.9, roughness: 0.2, name: 'customRim' } );


		// carParts.body.forEach( function ( part ) { part.material = bodyMat; } );
		carParts.body.forEach( function ( part ) { part.material = customBodyMat; } );
		carParts.interior.forEach( function ( part ) { part.material = customInteriorMat; } );

		carParts.rims.forEach( function ( part ) { part.material = rimMat; } );
		carParts.glass.forEach( function ( part ) { part.material = glassMat; } );

	}

	function onWindowResize() {

		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();

		renderer.setSize( window.innerWidth, window.innerHeight );

	}

	var driverOffset = new THREE.Vector3(-0.35, 1, 0.3);
	var yAxis = new THREE.Vector3(0, 1, 0);

	function update() {

		var delta = clock.getDelta();

		if ( carModel ) {

			car.update( delta / 3 );

			console.log(   );

			if ( carModel.position.length() > 200 ) {

				carModel.position.set( 0, 0, 0 );
				car.speed = 0;
			}

			if ( followCamera.checked ) {
				var camPos = driverOffset.clone();
				camPos.applyAxisAngle(yAxis, car.angle());
				camPos.add(carModel.position);
				camera.position.set(camPos.x, camPos.y, camPos.z);

				camera.rotation.set(0, car.angle(), 0);
			} else {

				carModel.getWorldPosition( cameraTarget );
				cameraTarget.y += 0.5;

				camera.position.set( 3.25, 2.0, -5 );
				camera.lookAt( carModel.position );
			}

		}

		stats.update();
	}

	init();

	</script>

</body>
</html>
