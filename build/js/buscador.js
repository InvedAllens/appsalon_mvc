
document.addEventListener("DOMContentLoaded",function(){
    iniciarApp();
});

function iniciarApp(){
    buscarCitas();
}

function buscarCitas(){
    const fecha=document.querySelector('#fecha');
    fecha.addEventListener('input', function(e){
        const fechaSeleccionada = e.target.value;
        window.location="?fecha="+fechaSeleccionada;
        
    });
}