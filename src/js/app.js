// let nombre=document.querySelector("#nombre");
// console.log(nombre);
// alert("hola desde cita "+ nombre.value);
//import Swal from 'sweetalert2/dist/sweetalert2.js';
let paso=1;
const pasoInicial=1;
const pasoFinal=3;

const cita={
    idusuario:'',
    fecha:'',
    hora:'',
    servicios:[]
}
document.addEventListener('DOMContentLoaded',function () {
    iniciarApp();
});
function iniciarApp(){
    cargarSeccion();
    tabs();//obtiene el tab clickeado para mostrar la seccion de cita 
    mostrarPaginacion();
    paginaAnterior();//navega a la pagina anterior
    paginaSiguiente();//navega a la pagina siguiente
    consultarAPIServicios();//consulta la API en el backend de php
    obtenerIdUsuario();
    obtenerNombre();//añade el nombre de usuario en el objeto cita
    seleccionarFecha();//añade la fecha al objeto cita
    seleccionarHora();

    // buscarCitas();
}
function cargarSeccion(){

    //mostror y ocultar la seccion selccionada 
    const seccionAnterior=document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }
    const selector=`#paso-${paso}`;
    if(paso===3){
        mostrarResumen();
    }
    const seccionActual=document.querySelector(selector);
    seccionActual.classList.add('mostrar');
    //modificar el tab con la clase actual 
    const tabAnterior=document.querySelector(".actual");
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }
    const tab=document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');

}
function tabs(){
    const botones=document.querySelectorAll(".tabs button");
    botones.forEach(boton=>{
        boton.addEventListener('click',(e)=>{
            paso=parseInt(e.target.dataset.paso);
            cargarSeccion();
            mostrarPaginacion();
            //console.log(e.target.dataset.paso);
        })
    });
    //console.log(botones);
}
function mostrarPaginacion(){
    const pagAnterior=document.querySelector("#anterior");
    const pagSiguiente=document.querySelector("#siguiente");
    if(paso===1){
        pagAnterior.classList.add('ocultar');
        pagSiguiente.classList.remove('ocultar');
    }else if(paso===3){
        pagSiguiente.classList.add('ocultar');
        pagAnterior.classList.remove('ocultar');
    }else{
        pagAnterior.classList.remove('ocultar');
        pagSiguiente.classList.remove('ocultar');
    }
}

function paginaAnterior(){
    const pagAnterior=document.querySelector("#anterior");
    pagAnterior.addEventListener('click',function(){
        if(paso<=pasoInicial) return;
        paso--;
        mostrarPaginacion();
        cargarSeccion();
    });
}
function paginaSiguiente(){
    const pagSiguiente=document.querySelector("#siguiente");
    pagSiguiente.addEventListener('click',function (){
        if(paso>=pasoFinal) return;
        paso++;
        mostrarPaginacion();
        cargarSeccion();
    });

}
async function consultarAPIServicios(){

    try{
        const url="http://localhost:3000/api/servicios";
        const resultado=await fetch(url);
        const servicios=await resultado.json();
        mostrarServicios(servicios);

    }catch(error){
        console.log(error);
    }
}
function mostrarServicios(servicios){
    
    servicios.forEach(servicio =>{

        const {idservicio,nombre,precio}=servicio;
        console.log(idservicio);
        const nombreServicio=document.createElement('P');
        nombreServicio.classList.add("nombre-servicio");
        nombreServicio.textContent=nombre;

        const precioServico=document.createElement('P');
        precioServico.classList.add("precio-servicio");
        precioServico.textContent=`$${precio}`;

        const servicioDiv=document.createElement('DIV');
        servicioDiv.classList.add("servicio");
        servicioDiv.onclick=function(){
            guardarServicio(servicio);
        }
        servicioDiv.dataset.idServicio=idservicio;

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServico);

        const servicios=document.querySelector("#servicios");
        servicios.appendChild(servicioDiv);

        console.log(servicioDiv);
        

    });
    
   // document.createElement('P');
}

function guardarServicio(servicio){
    const {servicios}=cita;
    const {idservicio}=servicio;
    const divServicio=document.querySelector(`[data-id-servicio='${idservicio}']`);
   
    //si el servicio selecionado ya se agrego en el arreglo previamente hay que eleiminarlo del arreglo de servicios
    //en el objeto cita y quitar la clase servicio-selecionado
    if(servicios.some(agregado =>agregado.idservicio===servicio.idservicio)){
        cita.servicios=servicios.filter(agregado => agregado.idservicio!=servicio.idservicio);
        divServicio.classList.remove("servicio-seleccionado");
    }else{
        cita.servicios=[...servicios,servicio];
        divServicio.classList.add("servicio-seleccionado");
    }
    //si no hay que agragarlo al arreglo de cita.servicios y agregar la clase servicio seleccionadp
    
    //MI OTRA VERSION
    // if(cita.servicios.includes(servicio)){
    //     divServicio.classList.remove("servicio-seleccionado");
    //     cita.servicios.splice(cita.servicios.indexOf(servicio),1);

    // }else{
    //     divServicio.classList.add("servicio-seleccionado");
    //     cita.servicios=[...servicios,servicio];
    // }
    
    //console.log(cita);

    //console.log(cita.servicios);
    
}
function obtenerIdUsuario(){
    cita.idusuario=document.querySelector('#idusuario').value;
}
function obtenerNombre(){
    cita.nombre=document.querySelector("#nombre").value;
}
function seleccionarFecha(){
    const fecha=document.querySelector("#fecha");
    fecha.addEventListener("input",e=>{
        const dia=new Date(e.target.value).getUTCDay();
        console.log(dia);
        if([0,6].includes(dia)){
            e.target.value='';
            mostrarAlerta("Fines de semana no permitidos",'error','form');
            console.log("No Abrimos sabados y domingos")
        }else{
            cita.fecha=e.target.value;
        }
    })
   
    
}
function seleccionarHora(){
    const campoHora=document.querySelector('#hora');
    campoHora.addEventListener('input',function(e){
        const hora=e.target.value.split(':')[0];
        if(hora<9 || hora>19){
            e.target.value='';
            mostrarAlerta('Nuestro horario es de 9 a 19 horas','error','form');
        }else{
            cita.hora=e.target.value;
        }
        console.log(hora);
    });
}

function mostrarAlerta(mensaje,tipo,claseElemento,desaparece=true){
    //previene que se creen mas alertas para mostrar
    if(document.querySelector(".alerta")) {
        document.querySelector(".alerta").remove();
    }
    //creacion e insercion del elelemto alerta
    const alertaDiv=document.createElement('DIV');
    alertaDiv.textContent=mensaje;
    alertaDiv.classList.add("alerta");
    alertaDiv.classList.add(tipo);
    const elemento=document.querySelector("."+claseElemento);
    elemento.appendChild(alertaDiv);
    //borramos el elemento alertaDiv despues de 3 segundos
    if(desaparece){
        setTimeout(function(){
            alertaDiv.remove()
        },3000);
    }
    
}
function mostrarResumen(){
    const resumen=document.querySelector(".seccion-resumen");
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }
    if(Object.values(cita).includes('')||cita.servicios.length<1){
        mostrarAlerta('Hacen falta datos de servicio, fecha u hora','error','seccion-resumen',false);
        console.log("Hacen falta datos para realizar la cita");
        return;
    }
    const resumenHeading=document.createElement('H3');
    resumenHeading.textContent='Servicios Seleccionados';
    resumen.appendChild(resumenHeading);

    const {nombre,fecha,hora,servicios}=cita;
    const nombreCliente=document.createElement('P');
    nombreCliente.innerHTML=`<span>Nombre:</span> ${nombre}`;

    //formato a fecha 
    const fechaObj=new Date(fecha);
    //se agregan dos al dia porque regresa desde el 0 y se utilizara tambien en fechaUTC
    const dia=fechaObj.getDate()+2;
    const mes=fechaObj.getMonth();
    const year=fechaObj.getFullYear();

    const fechaUTC=new Date(Date.UTC(year,mes,dia));
    const opciones={weekday:'long',year:'numeric',month:'long',day:'numeric'}
    const fechaFormateada=fechaUTC.toLocaleDateString('es-MX',opciones);
    const fechaCita=document.createElement('P');
    fechaCita.innerHTML=`<span>Fecha:</span> ${fechaFormateada}`;
    const horaCita=document.createElement('P');
    horaCita.innerHTML=`<span>Hora:</span> ${hora} horas`
    
    servicios.forEach(servicio=>{
        const servicioDiv=document.createElement('DIV');
        servicioDiv.classList.add('contenedor-servicio')
        const nombreServicio=document.createElement('P');
        nombreServicio.textContent=servicio.nombre;
        const precio=document.createElement('P');
        precio.innerHTML=`<span>Precio:</span>$${servicio.precio}`;
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precio);
        resumen.appendChild(servicioDiv);

    });

    const resumenDatos=document.createElement('H3');
    resumenDatos.textContent='Datos de la cita';
    resumen.appendChild(resumenDatos);
    const botonReservar=document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent='Confirmar Cita';
    botonReservar.onclick=reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);
    //console.log(cita);
}
async function reservarCita(){
    const {fecha,hora,nombre,servicios,idusuario}=cita;
    const idServicios=servicios.map(servicio => servicio.idservicio);
    const data=new FormData();
    //console.log(cita);
    //data.append('nombre',nombre);
    data.append('fecha',fecha);
    data.append('hora',hora);
    data.append('usuarioId',idusuario);
    data.append('servicios',idServicios);
    console.log([...data]);

    try {
        const url='http://localhost:3000/api/citas';
        const respuesta= await fetch(url,{
        method:'POST',
        body:data
        });
        const resultado=await respuesta.json();
        console.log(resultado.guardado);
        if(resultado.guardado){
            Swal.fire({
                icon: 'success',
                title: 'Cita Guardada',
                text: 'Su Cita fue Registrada con exito!',
                background:'#2f2f2f',
                color:'#fff',
                padding:'2rem',
                confirmButtonColor:'#0892e2d7'
            }).then(()=>{
                window.location.reload();
                });
         }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Cita No Registrada',
            text: 'Su Cita No Pudo ser Registrada!',
            background:'#2f2f2f',
            color:'#fff',
            padding:'2rem',
            confirmButtonColor:'#e01313d8'
          })
        
    }
    
}

// function buscarCitas(){
//     const fecha=document.querySelector('#fecha');
//     fecha.addEventListener('input', function(e){
//         const fechaSeleccionada = e.target.value;
//         console.log(fechaSeleccionada);
//         window.location="?fecha="+fechaSeleccionada;
//     });
// }