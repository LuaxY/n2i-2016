<!DOCTYPE html>
<html ng-app="VR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <title></title>
    <style>
        html {
            width: 100%;
            height: 100%;
        }

        body {
            margin: 0px;
            overflow: hidden;
            background-color: white;
            width: 100%;
            height: 100%;
        }

        #Game {
            position: relative;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            z-index: 10;
        }

    </style>
    <script src="{{ URL::asset('js/three.min.js') }}"></script>
    <script src="{{ URL::asset('js/OBJLoader.js') }}"></script>
    <script src="{{ URL::asset('js/MTLLoader.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.js') }}"></script>
    <script>
        var camera, scene, renderer;
        var controls;
        var element, container;
        var clock = new THREE.Clock();
        var menu;
        var mesh;
        var geometry;
        var material;
        var sky, sunSphere;
        var Door;
        var mixer;
        var ActionDoor = {};
        var Term;
        var mixerTerm;
        var ActionTerm = {};
        var GUIobjects = [];
        var Ismoving = 0;
        var LeftPosition = 300;
        var RightPosition = 298.1520043214178;
        var TeamPosition = 296.5812079946229
        var raycaster = new THREE.Raycaster();
        var mouse = new THREE.Vector2();

        function init() {
            renderer = new THREE.WebGLRenderer({
                antialias: true
            });
            renderer.setClearColor(new THREE.Color(0x000000));
            renderer.setPixelRatio(1);
            element = renderer.domElement;
            container = document.getElementById('Game');
            container.appendChild(element);
            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(65, 1, 0.001, 2000);
            camera.position.y = 16;
            camera.rotation.y = LeftPosition;
            camera.position.z = -3;
            scene.add(camera);
            //initSky()
            LoadAsset("door");
            var light = new THREE.AmbientLight(0x404040); // soft white light
            light.intensity = 4;
            light.castShadow = true;
            scene.add(light);
            var light2 = new THREE.PointLight(0xffffff)
            light2.intensity = 0.5;
            light2.castShadow = true;
            scene.add(light2);
            var jsonLoader = new THREE.JSONLoader();
            jsonLoader.load('{{ URL::asset("Assets/term.json") }}', function(geometry, materials) {
                materials.forEach(function(material) {
                    material.skinning = true;
                });
                Term = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
                mixerTerm = new THREE.AnimationMixer(Term);
                ActionTerm.scroll = mixerTerm.clipAction(geometry.animations[0]);
                ActionTerm.scroll.setEffectiveWeight(1);
                ActionTerm.scroll.enabled = true;
                ActionTerm.scroll.play();
                Term.position.set(35, 5, -5);
                Term.scale.set(4, 4, 4);
                Term.rotation.y = (-Math.PI / 2) + (-Math.PI / 12);
                scene.add(Term);
            });
            var jsonLoader2 = new THREE.JSONLoader();
            jsonLoader2.load('{{ URL::asset("Assets/Porte.json") }}', function(geometry, materials) {
                materials.forEach(function(material) {
                    material.skinning = true;
                });
                Door = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
                mixer = new THREE.AnimationMixer(Door);
                ActionDoor.hit = mixer.clipAction(geometry.animations[0]);
                ActionDoor.hit.setEffectiveWeight(1);
                ActionDoor.hit.enabled = true;
                ActionDoor.hit.play();
                Door.position.set(30, 5, -2);
                Door.scale.set(1, 1, 1);
                Door.rotation.y = (-Math.PI / 12);
                scene.add(Door);
            });
            var mtlLoader = new THREE.MTLLoader();
            mtlLoader.setPath('{{ URL::asset("Assets") }}/');
            mtlLoader.load('rond.mtl', function(materials) {
                materials.preload();
                var objLoader = new THREE.OBJLoader();
                objLoader.setMaterials(materials);
                objLoader.setPath('Assets/');
                objLoader.load('rond.obj', function(object) {
                    object.position.set(20, 5, 3);
                    object.scale.set(1, 1, 1);
                    object.rotation.y = (-Math.PI / 2) + (-Math.PI / 12);
                    object.name = "Pia";
                    GUIobjects.push(object);
                    scene.add(object);
                });
            });
            var mtlLoader2 = new THREE.MTLLoader();
            mtlLoader2.setPath('{{ URL::asset("Assets") }}/');
            mtlLoader2.load('world.mtl', function(materials) {
                materials.preload();
                var objLoader2 = new THREE.OBJLoader();
                objLoader2.setMaterials(materials);
                objLoader2.setPath('Assets/');
                objLoader2.load('world.obj', function(object) {
                    object.position.set(-5, 13, 16);
                    object.scale.set(2.5, 2.5, 2.5);
                    object.rotation.y = (-Math.PI / 2) + (-Math.PI / 12) - Math.PI / 2;
                    object.name = "Pia";
                    GUIobjects.push(object);
                    scene.add(object);
                    console.log("BOBO");
                });
            });
            setTimeout(resize, 1);
            window.addEventListener('resize', resize, false);
            container.addEventListener('mousedown', TouchStart, false);
            menu = document.getElementById('Menu');
            menu.addEventListener('mousedown', TouchStart, false);
            animate();
        }

        function resize() {
            var width = container.offsetWidth;
            var height = container.offsetHeight;
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
            renderer.setSize(width, height);
            renderer.domElement.style.width = "100%";
            renderer.domElement.style.height = "100%";
        }

        function animate(t) {
            var delta = clock.getDelta();
            renderer.render(scene, camera);
            if (mixer) {
                mixer.update(delta);
                //console.log(mixer);
            }
            if (mixerTerm) {
                mixerTerm.update(delta);
                //console.log(mixer);
            }
            switch (Ismoving) {
                case 0:
                    break;
                case 1:
                    camera.rotation.y -= delta * 2;
                    if (camera.rotation.y <= RightPosition) {
                        camera.rotation.y = RightPosition;
                        Ismoving = 0;
                        ShowMenu(true);
                    }
                    break;
                case 2:
                    camera.rotation.y += delta * 2;
                    if (camera.rotation.y >= LeftPosition) {
                        camera.rotation.y = LeftPosition;
                        Ismoving = 0;
                    }
                    break;
                case 3:
                    camera.rotation.y -= delta * 4;
                    if (camera.rotation.y <= TeamPosition) {
                        camera.rotation.y = TeamPosition;
                        Ismoving = 0;
                    }
                    break;
                default:
                    break;
            }
            requestAnimationFrame(animate);
        }

        function ShowMenu(visible) {
            if (visible) {
                //$("#Menu").css("display","block");
                $("#Menu").fadeIn();
            } else {
                $("#Menu").fadeOut();
            }
        }

        function resize() {
            var width = container.offsetWidth;
            var height = container.offsetHeight;
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
            renderer.setSize(width, height);
            renderer.domElement.style.width = "100%";
            renderer.domElement.style.height = "100%";
        }

        function LoadAsset(path) {
            var mtlLoader = new THREE.MTLLoader();
            mtlLoader.setPath('{{ URL::asset("Assets") }}/');
            mtlLoader.load(path + '.mtl', function(materials) {
                materials.preload();
                var objLoader = new THREE.OBJLoader();
                objLoader.setMaterials(materials);
                objLoader.setPath('{{ URL::asset("Assets") }}/');
                objLoader.load(path + '.obj', function(object) {
                    object.position.set(20, 5, 3);
                    object.scale.set(1, 1, 1);
                    object.rotation.y = (-Math.PI / 2) + (-Math.PI / 12);
                    scene.add(object);
                });
            });
        }

        function Move(value) {
            Ismoving = value;
        }

        function TouchStart(event) {
            if (camera.rotation.y == RightPosition) {
                Move(2);
                ShowMenu(false);
            }
            if (camera.rotation.y == LeftPosition) {
                Move(1);
            }
        }
        //controls.minPolarAngle = Math.PI / 2;

    </script>
    <style>
        .link {
            color: white;
            text-decoration: none;
        }

        .menuitem {
            width: 100%;
            padding: 10px;
            background-color: #37434f;
            opacity: 0.7;
            text-align: center;
            border-radius: 10px;
            box-sizing: border-box;
        }

        .menuitem:hover {
            background-color: #606d7a;
        }

    </style>
</head>
<body onload="init()">
    <div id="Game" style="background-color : black"> </div>
    <div id="Menu" style="display:none; position :absolute; width :100% ; height : 100%; top : 0%;z-index:999;">
        <div style="width :100% ;  padding :  15px 10%; box-sizing : border-box;">
            <div style="width : 100% ;  opacity :1; text-align : center; border-radius : 10px; box-sizing : border-box;"> <img style="max-width : 20% ;" src="Assets/Mascotte.png"></img>
            </div>
        </div>
        <div style="width :100% ;  padding :  15px 10%; box-sizing : border-box;">
            <div class="menuitem">
                <h1 style="width :100% ;"><a  class="link" href="{{ route('login') }}">Connexion</a></h1> </div>
        </div>
        <div style="width :100% ;  padding :  15px 10%; box-sizing : border-box;">
            <div class="menuitem">
                <h1 style="width :100% ;  color: black;"><a class="link" href="{{ route('register') }}">Inscription</a></h1> </div>
        </div>
        <div style="width :100% ;  padding :  15px 10%; box-sizing : border-box;">
            <div class="menuitem">
                <h1 style="width :100% ; margin-top : 20px;"><a  class="link" href="{{ route('formation.list') }}">Formations</a></h1> </div>
        </div>
    </div> <button onclick="init()">Launch</button> </body>
</html>
