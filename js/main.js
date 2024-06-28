import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

// Variables para las dimensiones de una celda individual
const maxLargoArray = JSON.parse(localStorage.getItem('maxLargo') );
const maxAnchoArray = JSON.parse(localStorage.getItem('maxAncho') );
const maxAlto = parseFloat(localStorage.getItem('maxAlto')); // Valor predeterminado si no está en localStorage

const numRows = 3;
const numCols = 7;

// Escena, Cámara, Renderizador
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 10000); // Incrementado el far clipping plane
camera.position.set(10, 30, 30); // Ajuste de la posición de la cámara
camera.lookAt(scene.position);

const renderer = new THREE.WebGLRenderer();
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);
const controls = new OrbitControls(camera, renderer.domElement);
renderer.setClearColor(0x87CEEB); // Código de color hexadecimal para azul claro

// Añadir ejes
const axesHelper = new THREE.AxesHelper(10);
scene.add(axesHelper);

// Material de las paredes
const wallMaterial = new THREE.MeshStandardMaterial({ 
    side: THREE.DoubleSide, 
    color: 0x5a6bd // Color turquesa
});

// Función para crear una celda
function crearCelda(posX, posY, posZ, cellLargo, cellAncho, cellAlto) {
    const cellGroup = new THREE.Group();

    // Frontal
    const frontPlane = new THREE.Mesh(new THREE.BoxGeometry(cellAncho, cellAlto, 0.1), wallMaterial);
    frontPlane.position.set(cellAncho / 2, cellAlto / 2, cellLargo / 2);
    cellGroup.add(frontPlane);

    // Trasera
    const backPlane = new THREE.Mesh(new THREE.BoxGeometry(cellAncho, cellAlto, 0.1), wallMaterial);
    backPlane.position.set(cellAncho / 2, cellAlto / 2, -cellLargo / 2);
    cellGroup.add(backPlane);

    // Izquierda
    const leftPlane = new THREE.Mesh(new THREE.BoxGeometry(0.1, cellAlto, cellLargo), wallMaterial);
    leftPlane.position.set(0, cellAlto / 2, 0);
    cellGroup.add(leftPlane);

    // Derecha
    const rightPlane = new THREE.Mesh(new THREE.BoxGeometry(0.1, cellAlto, cellLargo), wallMaterial);
    rightPlane.position.set(cellAncho, cellAlto / 2, 0);
    cellGroup.add(rightPlane);

    // Inferior
    const bottomPlane = new THREE.Mesh(new THREE.BoxGeometry(cellAncho, 0.1, cellLargo), wallMaterial);
    bottomPlane.position.set(cellAncho / 2, 0, 0);
    cellGroup.add(bottomPlane);

    // Posicionar la celda en la escena
    cellGroup.position.set(posX, posY, posZ);

    return cellGroup;
}

// Posición inicial de los cubos
let posZ = maxLargoArray[0] / 2;

for (let i = 0; i < numRows; i++) {
    let posX = 0;
    const cellLargo = maxLargoArray[i]; // Longitud de la fila actual

    if (i > 0) {
        const prevLargo = maxLargoArray[i - 1];
        posZ += (prevLargo / 2) + (cellLargo / 2); // Ajustar posZ sumando las mitades de las longitudes de la fila anterior y la fila actual
    }

    for (let j = 0; j < numCols; j++) {
        const cellAncho = maxAnchoArray[j]; // Ancho de la columna actual
        const cellAlto = maxAlto;

        // Creamos la celda y la añadimos a la escena
        const cell = crearCelda(posX, 0, posZ, cellLargo, cellAncho, cellAlto);
        scene.add(cell);

        posX += cellAncho; // Incrementamos posX por el ancho de la celda actual
    }
}


// Luces
const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
scene.add(ambientLight);

const directionalLight = new THREE.DirectionalLight(0xffffff, 0.5);
directionalLight.position.set(2, 4, 4);
scene.add(directionalLight);

const directionalLight2 = new THREE.DirectionalLight(0xffffff, 0.5);
scene.add(directionalLight2);

// Calcular automáticamente la posición y el enfoque de la cámara en función de los objetos en la escena
function ajustarCamaraAutomaticamente(scene, camera) {
    // Crear un cuadro delimitador (bounding box) para la escena
    const boundingBox = new THREE.Box3().setFromObject(scene);

    // Calcular el centro del bounding box
    const center = boundingBox.getCenter(new THREE.Vector3());

    // Calcular el tamaño del bounding box
    const size = boundingBox.getSize(new THREE.Vector3());

    // Calcular la distancia necesaria para que todos los objetos estén dentro del campo de visión
    const maxDim = Math.max(size.x, size.y, size.z);
    const fov = camera.fov * (Math.PI / 180);
    let distance = Math.abs(maxDim / Math.sin(fov / 2));

    // Reducir la distancia para acercar la cámara
    distance *= 0.4; // Puedes ajustar este factor según sea necesario para acercar más o menos la cámara

    // Ajustar la posición de la cámara para que mire desde un ángulo
    const angle = Math.PI / 4; // Ángulo desde el lado y un poco desde arriba
    camera.position.x = center.x + Math.cos(angle) * distance;
    camera.position.y = center.y + distance / 2; // Ligeramente desde arriba
    camera.position.z = center.z + Math.sin(angle) * distance;

    // Configurar el punto de enfoque de la cámara
    camera.lookAt(center);
}

// Animación
function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
}

ajustarCamaraAutomaticamente(scene, camera);
animate();
