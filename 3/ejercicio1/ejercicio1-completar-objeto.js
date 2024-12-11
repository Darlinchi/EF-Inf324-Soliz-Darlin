var camera, scene, renderer;
var cameraControls;
var clock = new THREE.Clock();
var ambientLight, light;

function init() {
    var canvasWidth = window.innerWidth * 0.9;
    var canvasHeight = window.innerHeight * 0.9;

    // CAMERA
    camera = new THREE.PerspectiveCamera(45, canvasWidth / canvasHeight, 1, 80000);
    camera.position.set(-1, 1, 3);
    camera.lookAt(0, 0, 0);

    // LIGHTS
    light = new THREE.DirectionalLight(0xFFFFFF, 0.7);
    light.position.set(1, 1, 1);

    ambientLight = new THREE.AmbientLight(0x333333); // Luz ambiental tenue

    // RENDERER
    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(canvasWidth, canvasHeight);
    renderer.setClearColor(0xAAAAAA, 1.0);

    // Add to DOM
    var container = document.getElementById('container');
    container.appendChild(renderer.domElement);

    // CONTROLS
    cameraControls = new THREE.OrbitControls(camera, renderer.domElement);
    cameraControls.target.set(0, 0, 0);

    // OBJECT
    var geometry = new THREE.Geometry();

    // Vértices del cubo
    geometry.vertices.push(
        new THREE.Vector3(0, 0, 0),    // 0
        new THREE.Vector3(1, 0, 0),    // 1
        new THREE.Vector3(1, 1, 0),    // 2
        new THREE.Vector3(0, 1, 0),    // 3
        new THREE.Vector3(0, 0, -1),   // 4
        new THREE.Vector3(1, 0, -1),   // 5
        new THREE.Vector3(1, 1, -1),   // 6
        new THREE.Vector3(0, 1, -1)    // 7
    );

    // Caras del cubo (definidas en sentido antihorario)
    geometry.faces.push(
        // Frente
        new THREE.Face3(0, 1, 2),
        new THREE.Face3(0, 2, 3),

        // Atrás
        new THREE.Face3(4, 6, 5),
        new THREE.Face3(4, 7, 6),

        // Lado derecho
        new THREE.Face3(1, 5, 6),
        new THREE.Face3(1, 6, 2),

        // Lado izquierdo
        new THREE.Face3(0, 3, 7),
        new THREE.Face3(0, 7, 4),

        // Arriba
        new THREE.Face3(3, 2, 6),
        new THREE.Face3(3, 6, 7),

        // Abajo
        new THREE.Face3(0, 4, 5),
        new THREE.Face3(0, 5, 1)
    );

    // Cálculo de normales
    geometry.computeFaceNormals();
    geometry.computeVertexNormals();

    // Material del cubo
    var material = new THREE.MeshPhongMaterial({
        color: 0x0000FF,       // Color azul
    	specular: 0x555555,    // Reflejo especular
        shininess: 30,
        side: THREE.DoubleSide
    });

    var cube = new THREE.Mesh(geometry, material);

    // SCENE
    scene = new THREE.Scene();
    scene.add(light);
    scene.add(ambientLight);
    scene.add(cube);
}

function animate() {
    window.requestAnimationFrame(animate);
    render();
}

function render() {
    var delta = clock.getDelta();
    cameraControls.update(delta);
    renderer.render(scene, camera);
}

try {
    init();
    animate();
} catch (e) {
    var errorReport = "Your program encountered an unrecoverable error, cannot draw on canvas. Error was:<br/><br/>";
    var container = document.getElementById('container');
    container.innerHTML += errorReport + e;
}
