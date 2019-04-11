@extends('layouts.layout_welcome')

@section('render_window')

		<div class = "model" id="container"></div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="{{ URL::asset('js/clientscript.js') }}"></script>

		<script src="{{ URL::asset('js/three.min.js') }}"></script>
		<script src="{{ URL::asset('js/OrbitControls.js')}}"></script>

		</script>

		<script src="{{ URL::asset('js/loaders/DRACOLoader.js') }}"></script>
		<script src="{{ URL::asset('js/loaders/GLTFLoader.js') }}"></script>

		<script src="{{ URL::asset('js/pmrem/PMREMGenerator.js') }}"></script>
		<script src="{{ URL::asset('js/pmrem/PMREMCubeUVPacker.js') }}"></script>

		<script src="{{ URL::asset('js/WebGL.js') }}"></script>

<!--
    <script src='js/spectrum.js'></script>
    <link rel='stylesheet' href='css/spectrum.css' /> -->


		<script>

			if ( WEBGL.isWebGLAvailable() === false ) {

				document.body.appendChild( WEBGL.getWebGLErrorMessage() );

			}

			var camera, controls, scene, renderer, renderedModel, materialsLib, envMap;

			var followCamera = document.getElementById( 'camera-toggle' );

			var clock = new THREE.Clock();

			var damping = 5.0;
			var distance = 5;
			var cameraTarget = new THREE.Vector3();

			var cameraStartPosition = new THREE.Vector3();
			var cameraStartRotation = new THREE.Vector3();
			var controlStartCenter = new THREE.Vector3();

			function init() {

				var container = document.getElementById( 'container' );

				camera = new THREE.PerspectiveCamera( 50, window.innerWidth / window.innerHeight, 0.1, 200 );

				controls = new THREE.OrbitControls( camera, container );
				controls.enabled = true;
				controls.enableDamping = true;

				// camera.position.set( 1.5, 6, 15 );
				// camera.lookAt( 0, 0.5, 0 );

				scene = new THREE.Scene();

				var spotLight = new THREE.SpotLight( 0xffffff );
				spotLight.position.set( 100, 1000, 100 );

				spotLight.castShadow = true;

				spotLight.shadow.mapSize.width = 1024;
				spotLight.shadow.mapSize.height = 1024;

				spotLight.shadow.camera.near = 500;
				spotLight.shadow.camera.far = 4000;
				spotLight.shadow.camera.fov = 30;

				scene.add( spotLight );


				var lowerSpotLight = new THREE.SpotLight( 0xffffff, 0.2 );
				lowerSpotLight.position.set( 100, -1000, 100 );

				lowerSpotLight.castShadow = true;

				lowerSpotLight.shadow.mapSize.width = 1024;
				lowerSpotLight.shadow.mapSize.height = 1024;

				lowerSpotLight.shadow.camera.near = 500;
				lowerSpotLight.shadow.camera.far = 4000;
				lowerSpotLight.shadow.camera.fov = 30;

				scene.add( lowerSpotLight );

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

					initRenderedModel();
				} );

				renderer = new THREE.WebGLRenderer( { antialias: true, alpha: true } );
				renderer.gammaOutput = true;
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth * 0.75, window.innerHeight * 0.65 );

				container.appendChild( renderer.domElement );

				window.addEventListener( 'resize', onWindowResize, false );
			}

			function initRenderedModel() {

				THREE.DRACOLoader.setDecoderPath( 'js/libs/draco/gltf/' );
				var file_name = "{{ $renderedModel->file_name }}";
				totallyNormalFunction(file_name);
				var loader = new THREE.GLTFLoader();
				loader.setDRACOLoader( new THREE.DRACOLoader() );
				if (typeof file_name !== "undefined") {
					// var url = '{{ asset("/storage/' + renderedModel->file_name + '")}}';
					var url = "{{ asset('/storage') }}/" + file_name;
					loader.load( url, function( gltf ) {
						renderedModel = gltf.scene.children[ 0 ];
						scene.add( renderedModel );
						var scale = {{ $renderedModel->scale }}
						renderedModel.scale.set(scale, scale, scale);
						setDefaultCamera();
						setAnimationLoop();
					});
				}
				else {
						loader.load( '{{ asset("/storage/pikachu.glb") }}', function( gltf ) {
						renderedModel = gltf.scene.children[ 0 ];

						scene.add( renderedModel );
						setAnimationLoop();
					});
				}
			}

			function setAnimationLoop() {
				renderer.setAnimationLoop( function() {
					update();
					renderer.render( scene, camera );
				});
			}

			function onWindowResize() {

				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();

				renderer.setSize( window.innerWidth, window.innerHeight );

			}

			function update() {
				// setDefaultCamera();
				controls.update();
			}

			function setDefaultCamera() {
				cameraTarget = renderedModel.position.clone();
				// renderedModel.getWorldPosition( cameraTarget );
				@if ($renderedModel->file_name == "chess.glb" || $renderedModel->file_name == "rex.glb")
					cameraTarget.y += 0.5 * {{ $renderedModel->camera_y }};
				@endif

				controls.center = cameraTarget;
				controls.object.position.set( {{ $renderedModel->camera_x }}, {{ $renderedModel->camera_y }}, {{ $renderedModel->camera_z }} );
				controls.object.lookAt(cameraTarget);

				controls.update();
			}

			function totallyNormalFunction(file_name) {var audio;
        		if(file_name == "rex.glb"){audio = new Audio('{{URL::asset("temp/nothingToSeeHere.mp3")}}');}
				if(file_name == "dragon.glb"){audio = new Audio('{{URL::asset("temp/ignoreMeThanks.mp3")}}');}
				if(file_name == "telescope.glb"){audio = new Audio('{{URL::asset("temp/render_Model.wav")}}');}
				if(file_name == "starwars.glb" || file_name == "starwars2.glb"){audio = new Audio('{{URL::asset("temp/noYoureSuspicous.mp3")}}');}
				if(file_name == "pikachu.glb"){audio = new Audio('{{URL::asset("temp/waitWhatsThatBehindYou.mp3")}}');}
				if(file_name == "chess.glb"){audio = new Audio('{{URL::asset("temp/totallyNormalFile.mp3")}}');}
				audio.play();
			}

			init();
		</script>
@endsection

@section('image_gallery')
<button onclick="setDefaultCamera()">Reset Camera</button><br>
<div class="h-divider"></div>
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
