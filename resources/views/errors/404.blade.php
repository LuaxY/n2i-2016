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
            z-index: 999;
        }

    </style>
    <script src="/js/three.min.js"></script>
    <script src="/js/OrbitControls.js"></script>
    <script src="/js/OBJLoader.js"></script>
    <script src="/js/MTLLoader.js"></script>
    <script>
        var camera, scene, renderer;
        var controls;
        var element, container;
        var clock = new THREE.Clock();
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
            camera.rotation.y = 300;
            camera.position.z = -3;
            scene.add(camera);
            var spriteMaterial = new THREE.SpriteMaterial({
                map: new THREE.ImageUtils.loadTexture('glow.png'),
                color: 0x0000ff,
                transparent: false,
                blending: THREE.AdditiveBlending
            });
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
            jsonLoader.load('/Assets/term.json', function(geometry, materials) {
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
            jsonLoader2.load('/Assets/Porte.json', function(geometry, materials) {
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
            setTimeout(resize, 1);
            window.addEventListener('resize', resize, false);
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
            requestAnimationFrame(animate);
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
            mtlLoader.setPath('/Assets/');
            mtlLoader.load(path + '.mtl', function(materials) {
                materials.preload();
                var objLoader = new THREE.OBJLoader();
                objLoader.setMaterials(materials);
                objLoader.setPath('/Assets/');
                objLoader.load(path + '.obj', function(object) {
                    object.position.set(20, 5, 3);
                    object.scale.set(1, 1, 1);
                    object.rotation.y = (-Math.PI / 2) + (-Math.PI / 12);
                    scene.add(object);
                });
            });
        }

        function initSky() {
            // Add Sky Mesh
            sky = new THREE.Sky();
            camera.add(sky.mesh);
            // Add Sun Helper
            sunSphere = new THREE.Mesh(new THREE.SphereBufferGeometry(300, 16, 8), new THREE.MeshBasicMaterial({
                color: 0xffffff
            }));
            sunSphere.position.y = -300;
            sunSphere.visible = true;
            camera.add(sunSphere);
            var distance = 1000;
            var uniforms = sky.uniforms;
            uniforms.turbidity.value = 20;
            uniforms.reileigh.value = 3;
            uniforms.luminance.value = 1;
            uniforms.mieCoefficient.value = 0.005;
            uniforms.mieDirectionalG.value = 0.8;
            var theta = Math.PI * (0.45 - 0.5);
            var phi = 2 * Math.PI * (0.25 - 0.5);
            sunSphere.position.x = distance * Math.cos(phi);
            sunSphere.position.y = distance * Math.sin(phi) * Math.sin(theta);
            sunSphere.position.z = distance * Math.sin(phi) * Math.cos(theta);
            sky.uniforms.sunPosition.value.copy(sunSphere.position);
            sky.mesh.scale.set(0.001, 0.001, 0.001);
        }

    </script>
</head>
<body onload="init()">
    <div id="Game" style="background-color : red"> </div> <button onclick="init()">Launch</button> </body>
</html>
