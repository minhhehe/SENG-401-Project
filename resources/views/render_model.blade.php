<?php
	$loadFull = ($renderedModel->file_name == "ferrari.glb");
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title> FK BS 2019 </title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
		<script src="{{ asset('js/app.js') }}"></script>
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
		<!-- Left Side Of Navbar -->
		<a class="navbar-brand" href="{{ url('/') }}">
			<!-- {{ config('app.name', 'Laravel') }} -->
			FKBmb Background Simulator 2019
		</a>
		<ul class="navbar-nav mr-auto">
		</ul>
		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
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
						<a title = "User Information" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
						{{ Auth::user()->fname }} {{ Auth::user()->lname}} <span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{ url('/home') }}">Your Account
							<a>
								<div class="h-divider"></div>
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
		<div id="container"></div>
		<button class="btn btn-secondary topRight" onclick="document.location.href='{{ url('/submitted') }}'"> Submit </button>
		</div>
		<script src="{{ asset('js/three.min.js') }}"></script>
		<script src="{{ asset('js/loaders/DRACOLoader.js') }}"></script>
		<script src="{{ asset('js/loaders/GLTFLoader.js') }}"></script>
		<script src="{{ asset('js/pmrem/PMREMGenerator.js') }}"></script>
		<script src="{{ asset('js/pmrem/PMREMCubeUVPacker.js') }}"></script>
		<script src="{{ asset('js/Car.js') }}"></script>
		<script src="{{ asset('js/WebGL.js') }}"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>
			if ( WEBGL.isWebGLAvailable() === false ) {

				document.body.appendChild( WEBGL.getWebGLErrorMessage() );

			}

			var camera, scene, renderer, carModel, envMap;

			var bodyMatSelect = document.getElementById( 'body-mat' );
			var rimMatSelect = document.getElementById( 'rim-mat' );
			var glassMatSelect = document.getElementById( 'glass-mat' );
			var customBodyMatSelect = $('#custom-body-mat');
			var customInteriorMatSelect = $('#custom-interior-mat');

			var customBodyColour = "#FFFFFF";
			var customInteriorColour = "#222222";

			console.log(customBodyMatSelect);

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
				// scene.fog = new THREE.Fog( 0xd7cbb1, 1, 80 );

				var urls = [ 'px.jpg', 'nx.jpg', 'py.jpg', 'ny.jpg', 'pz.jpg', 'nz.jpg' ];
				var loader = new THREE.CubeTextureLoader().setPath( '{{ asset('textures/cube/skyboxsun25deg') }}/');

				loader.load( urls, function ( texture ) {

					// scene.background = texture;
					//
					var pmremGenerator = new THREE.PMREMGenerator( texture );
					pmremGenerator.update( renderer );

					var pmremCubeUVPacker = new THREE.PMREMCubeUVPacker( pmremGenerator.cubeLods );
					pmremCubeUVPacker.update( renderer );

					envMap = pmremCubeUVPacker.CubeUVRenderTarget.texture;

					pmremGenerator.dispose();
					pmremCubeUVPacker.dispose();

					//

					initCar();

				} );

				// var ground = new THREE.Mesh(
				// 	new THREE.PlaneBufferGeometry( 2400, 2400 ),
				// 	new THREE.ShadowMaterial( { color: 0x000000, opacity: 0.15, depthWrite: false }
				// ) );
				// ground.rotation.x = - Math.PI / 2;
				// ground.receiveShadow = true;
				// ground.renderOrder = 1;
				// scene.add( ground );

				// var grid = new THREE.GridHelper( 400, 40, 0x000000, 0x000000 );
				// grid.material.opacity = 0.2;
				// grid.material.depthWrite = false;
				// grid.material.transparent = true;
				// scene.add( grid );

				renderer = new THREE.WebGLRenderer( { antialias: true, alpha: true } );
				renderer.gammaOutput = true;
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth * 0.75, window.innerHeight * 0.65 );

				container.appendChild( renderer.domElement );

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
					// car parts for material selection
					carParts.body.push( carModel.getObjectByName( 'body' ) );

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

					@endif
				});

			}

			function onWindowResize() {

				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();

				renderer.setSize( window.innerWidth, window.innerHeight );

			}

			function update() {

				var delta = clock.getDelta();

				if ( carModel ) {

					car.update( delta / 3 );

					console.log(   );

					if ( carModel.position.length() > 200 ) {

						carModel.position.set( 0, 0, 0 );
						car.speed = 0;
					}


					carModel.getWorldPosition( cameraTarget );
					cameraTarget.y += 0.5;

					camera.position.set( 3.25, 2.0, -5 );
					camera.lookAt( carModel.position );
				}
			}

			init();

		</script>
	</body>
</html>
