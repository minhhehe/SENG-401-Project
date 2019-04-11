@extends('layouts.layout_welcome')

@section('render_window')

		<div class = "model" id="container"></div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="{{ URL::asset('js/clientscript.js') }}"></script>


		<script src="{{ URL::asset('js/three.min.js') }}"></script>

		<script src="{{ URL::asset('js/loaders/DRACOLoader.js') }}"></script>
		<script src="{{ URL::asset('js/loaders/GLTFLoader.js') }}"></script>

		<script src="{{ URL::asset('js/pmrem/PMREMGenerator.js') }}"></script>
		<script src="{{ URL::asset('js/pmrem/PMREMCubeUVPacker.js') }}"></script>

		<!-- <script src="js/Car.js"></script> -->

		<script src="{{ URL::asset('js/WebGL.js') }}"></script>
		<script src="{{ URL::asset('js/libs/stats.min.js') }}"></script>

<!--
    <script src='js/spectrum.js'></script>
    <link rel='stylesheet' href='css/spectrum.css' /> -->


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

			var damping = 5.0;
			var distance = 5;
			var cameraTarget = new THREE.Vector3();

			function init() {

				var container = document.getElementById( 'container' );

				camera = new THREE.PerspectiveCamera( 50, window.innerWidth / window.innerHeight, 0.1, 200 );
				camera.position.set( 3.25, 2.0, -5 );
				camera.lookAt( 0, 0.5, 0 );

				scene = new THREE.Scene();
				scene.add(new THREE.AmbientLight());
				// scene.fog = new THREE.Fog( 0xd7cbb1, 1, 80 );

				var urls = [ 'px.jpg', 'nx.jpg', 'py.jpg', 'ny.jpg', 'pz.jpg', 'nz.jpg' ];
				var string = "{{URL::asset('textures/cube/skyboxsun25deg/')}}" + '/';
				var loader = new THREE.CubeTextureLoader().setPath(string);

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

					initCar();
				} );

				renderer = new THREE.WebGLRenderer( { antialias: true, alpha: true } );
				renderer.gammaOutput = true;
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth * 0.75, window.innerHeight * 0.65 );

				container.appendChild( renderer.domElement );

				stats = new Stats();

				window.addEventListener( 'resize', onWindowResize, false );

				renderer.setAnimationLoop( function() {

					update();

					renderer.render( scene, camera );
				} );

			}

			function initCar() {

				THREE.DRACOLoader.setDecoderPath( 'js/libs/draco/gltf/' );
				var file_name = "{{ $renderedModel->file_name }}";
				var loader = new THREE.GLTFLoader();
				loader.setDRACOLoader( new THREE.DRACOLoader() );
				if (typeof file_name !== "undefined") {
						// var url = '{{ asset("/storage/' + renderedModel->file_name + '")}}';
						console.log(file_name);
						var url = "{{ asset('/storage') }}/" + file_name;
						console.log(url);
						loader.load( url, function( gltf ) { // ------------- TODO Redirect to dynamic path instead of ferrari ---------------
							carModel = gltf.scene.children[ 0 ];
							scene.add( carModel );
						});
				}
				else {
						console.log('hello else');
						loader.load( '{{ asset("/storage/pikachu.glb") }}', function( gltf ) { // ------------- TODO Redirect to dynamic path instead of ferrari ---------------
						carModel = gltf.scene.children[ 0 ];

						// car.setModel( carModel );
						//
						// carModel.traverse( function ( child ) {
						//
						// 	if ( child.isMesh  ) {
						// 		child.material.envMap = envMap;
						// 	}
						//
						// } );

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
						// carParts.body.push( carModel.getObjectByName( 'body' ) );
						//
						// carParts.interior.push(carModel.getObjectByName('leather'));
						//
						// carParts.rims.push(
						// 	carModel.getObjectByName( 'rim_fl' ),
						// 	carModel.getObjectByName( 'rim_fr' ),
						// 	carModel.getObjectByName( 'rim_rr' ),
						// 	carModel.getObjectByName( 'rim_rl' ),
						// 	carModel.getObjectByName( 'trim' ),
						// );
						//
						// carParts.glass.push(
						// 	carModel.getObjectByName( 'glass' ),
						//  );

						// updateMaterials();
				});
			}
			}

			function updateMaterials() {
			}

			function onWindowResize() {

				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();

				renderer.setSize( window.innerWidth, window.innerHeight );

			}

			function update() {
				// 		carModel.getWorldPosition( cameraTarget );
				// 		cameraTarget.y += 0.5;
				//

				@if (false)
				camera.position.set( {{ $renderedModel->camera_x }}, {{ $renderedModel->camera_y }}, {{ $renderedModel->camera_z }} );
				camera.lookAt( carModel.position );
				@endif
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
		<div id="imageSectionContainer" style="background:blue;margin-top:10px;">
			<div id="imageSection" class="flex-container" style="justify-content: center; flex-wrap: wrap; margin:auto;">
			</div>
		</div>
	@else
		<div id="imageSectionContainer" style="background:red;">
				<div id="imageSection" class="flex-container" style="justify-content: center;margin:auto;">
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
