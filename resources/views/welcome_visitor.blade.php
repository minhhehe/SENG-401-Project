@extends('layouts.layout_welcome')

@section('render_window')

		<div class = "model" id="container"></div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="js/clientscript.js"></script>


		<script src="js/three.min.js"></script>

		<script src="js/loaders/DRACOLoader.js"></script>
		<script src="js/loaders/GLTFLoader.js"></script>

		<script src="js/pmrem/PMREMGenerator.js"></script>
		<script src="js/pmrem/PMREMCubeUVPacker.js"></script>

		<script src="js/Car.js"></script>

		<script src="js/WebGL.js"></script>
		<script src="js/libs/stats.min.js"></script>


    <script src='js/spectrum.js'></script>
    <link rel='stylesheet' href='css/spectrum.css' />


		<script>

			if ( WEBGL.isWebGLAvailable() === false ) {

				document.body.appendChild( WEBGL.getWebGLErrorMessage() );

			}

			var camera, scene, renderer, stats, carModel, materialsLib, envMap;

			var bodyMatSelect = document.getElementById( 'body-mat' );
			var rimMatSelect = document.getElementById( 'rim-mat' );
			var glassMatSelect = document.getElementById( 'glass-mat' );
			var customBodyMatSelect = $('#custom-body-mat');
			var customInteriorMatSelect = $('#custom-interior-mat');

			var customBodyColour = "#FFFFFF";
			var customInteriorColour = "#222222";

			console.log(customBodyMatSelect);

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
				// scene.fog = new THREE.Fog( 0xd7cbb1, 1, 80 );

				var urls = [ 'px.jpg', 'nx.jpg', 'py.jpg', 'ny.jpg', 'pz.jpg', 'nz.jpg' ];
				var loader = new THREE.CubeTextureLoader().setPath( 'textures/cube/skyboxsun25deg/');

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
					initMaterials();
					initMaterialSelectionMenus();

				} );

				renderer = new THREE.WebGLRenderer( { antialias: true, alpha: true } );
				renderer.gammaOutput = true;
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth * 0.75, window.innerHeight * 0.65 );

				container.appendChild( renderer.domElement );

				stats = new Stats();
				// container.appendChild( stats.dom );

				window.addEventListener( 'resize', onWindowResize, false );

				renderer.setAnimationLoop( function() {

					update();

					renderer.render( scene, camera );

				} );

			}

			function initCar() {

				THREE.DRACOLoader.setDecoderPath( 'js/libs/draco/gltf/' );

				var loader = new THREE.GLTFLoader();
				loader.setDRACOLoader( new THREE.DRACOLoader() );

				loader.load( 'storage/ferrari.glb', function( gltf ) { // ------------- TODO Redirect to dynamic path instead of ferrari ---------------

					carModel = gltf.scene.children[ 0 ];

					car.setModel( carModel );

					carModel.traverse( function ( child ) {

						if ( child.isMesh  ) {
							child.material.envMap = envMap;
						}

					} );

					// shadow
					// var texture = new THREE.TextureLoader().load( 'storage/ferrari_ao.png' ); // ------------- TODO Redirect to dynamic path instead of ferrari ---------------
					// var shadow = new THREE.Mesh(
					// 	new THREE.PlaneBufferGeometry( 0.655 * 4, 1.3 * 4 ).rotateX( - Math.PI / 2 ),
					// 	new THREE.MeshBasicMaterial( { map: texture, opacity: 0.8, transparent: true } )
					// );
					// shadow.renderOrder = 2;
					// carModel.add( shadow );

					scene.add( carModel );

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

					updateMaterials();

				});

			}

			function initMaterials() {

				materialsLib = {

					main: [

						new THREE.MeshStandardMaterial( { color: 0xff4400, envMap: envMap, metalness: 0.9, roughness: 0.2, name: 'orange' } ),
						new THREE.MeshStandardMaterial( { color: 0x001166, envMap: envMap, metalness: 0.9, roughness: 0.2, name: 'blue' } ),
						new THREE.MeshStandardMaterial( { color: 0x006611, envMap: envMap, metalness: 0.9, roughness: 0.2, name: 'green' } ),
						new THREE.MeshStandardMaterial( { color: 0x990000, envMap: envMap, metalness: 0.9, roughness: 0.2, name: 'red' } ),
						new THREE.MeshStandardMaterial( { color: 0x000000, envMap: envMap, metalness: 0.9, roughness: 0.5, name: 'black' } ),
						new THREE.MeshStandardMaterial( { color: 0xffffff, envMap: envMap, metalness: 0.9, roughness: 0.5, name: 'white' } ),
						new THREE.MeshStandardMaterial( { color: 0x555555, envMap: envMap, envMapIntensity: 2.0, metalness: 1.0, roughness: 0.2, name: 'metallic' } ),

					],

					glass: [

						new THREE.MeshStandardMaterial( { color: 0xffffff, envMap: envMap, metalness: 1, roughness: 0, opacity: 0.2, transparent: true, premultipliedAlpha: true, name: 'clear' } ),
						new THREE.MeshStandardMaterial( { color: 0x000000, envMap: envMap, metalness: 1, roughness: 0, opacity: 0.2, transparent: true, premultipliedAlpha: true, name: 'smoked' } ),
						new THREE.MeshStandardMaterial( { color: 0x001133, envMap: envMap, metalness: 1, roughness: 0, opacity: 0.2, transparent: true, premultipliedAlpha: true, name: 'blue' } ),

					],

				}

			}

			function initMaterialSelectionMenus() {

				function addOption( name, menu ) {

					var option = document.createElement( 'option' );
					option.text = name;
					option.value = name;
					menu.add( option );

				}

				materialsLib.main.forEach( function( material ) {

					addOption( material.name, bodyMatSelect );
					addOption( material.name, rimMatSelect );

				} );

				materialsLib.glass.forEach( function( material ) {

					addOption( material.name, glassMatSelect );

				} );

				bodyMatSelect.selectedIndex = 3;
				rimMatSelect.selectedIndex = 5;
				glassMatSelect.selectedIndex = 0;

				bodyMatSelect.addEventListener( 'change', updateMaterials );
				rimMatSelect.addEventListener( 'change', updateMaterials );
				glassMatSelect.addEventListener( 'change', updateMaterials );

				$("#custom-body-mat").spectrum({
					flat: false,
				    showInitial: true,
				    showValue: true,

					color: customBodyColour,

					change: function(color) {
						customBodyColour = color.toHexString();
						console.log(customBodyColour);
						updateMaterials();
					},

					move: function(color) {
						customBodyColour = color.toHexString();
						console.log(customBodyColour);
						updateMaterials();
					}
				});

				$("#custom-interior-mat").spectrum({
					flat: false,
				    showInitial: true,
				    showValue: true,

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
			}



			// set materials to the current values of the selection menus
			function updateMaterials() {

				var bodyMat = materialsLib.main[ bodyMatSelect.selectedIndex ];
				var rimMat = materialsLib.main[ rimMatSelect.selectedIndex ];
				var glassMat = materialsLib.glass[ glassMatSelect.selectedIndex ];


				var customBodyMat = new THREE.MeshStandardMaterial( { color: customBodyColour, envMap: envMap, metalness: 0.9, roughness: 0.2, name: 'customBody' } );
				var customInteriorMat = new THREE.MeshStandardMaterial( { color: customInteriorColour, envMap: envMap, metalness: 0.3, roughness: 0.2, name: 'customInterior' } );

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

			function update() {

				// var delta = clock.getDelta();
				//
				// if ( carModel ) {
				//
				// 	car.update( delta / 3 );
				//
				// 	console.log(   );
				//
				// 	if ( carModel.position.length() > 200 ) {
				//
				// 		carModel.position.set( 0, 0, 0 );
				// 		car.speed = 0;
				// 	}
				//
				//
				//
				// 		carModel.getWorldPosition( cameraTarget );
				// 		cameraTarget.y += 0.5;
				//
				// 		camera.position.set( 3.25, 2.0, -5 );
				// 		camera.lookAt( carModel.position );
				//
				//
				// }

				stats.update();
			}

			init();
		</script>
@endsection

@section('image_gallery')
  @auth
		<input class="input" id="flickr_data" type="text" placeholder="Text input">
		<button id="grab_flickr_button"> Search Flickr </button>
		<br>
		<div id="imageSection" style="background:blue;"> </div>
	@else
		<div id="imageSection" style="background:red;">
				<div class="flex-container" style="justify-content: center;margin:auto;">
					<div><img id='thumb_0' style="width:100px;height:100px;" src='http://localhost:8000/storage/default1.jpg' onclick="swapBackround('http://localhost:8000/storage/default1.jpg')"></div>
					<div><img id='thumb_1' style='width:100px;height:100px;' src='http://localhost:8000/storage/default2.jpg' onclick="swapBackround('http://localhost:8000/storage/default2.jpg')"></div>
					<div><img id='thumb_2' style='width:100px;height:100px;' src='http://localhost:8000/storage/default3.jpg' onclick="swapBackround('http://localhost:8000/storage/default3.jpg')"></div>
				</div>
		</div>
  @endauth
@stop

@section('model_background')
<img id="model_backdrop" src="http://localhost:8000/storage/default0.jpg">
@stop
