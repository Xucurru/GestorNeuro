/*JS de la vista usuarios*/

const frm = document.querySelector("#formulario");
const btnNuevo = document.querySelector("#btnNuevo");
const title = document.querySelector("#title");

const modalRegistro = document.querySelector("#modalRegistro");

/*Crea instacia de modal*/
const myModal = new bootstrap.Modal(modalRegistro);

let tblUsuarios;

document.addEventListener("DOMContentLoaded", function () {
    //Cargar datos con DATATABLES

   tblUsuarios = $('#tblUsuarios').DataTable( {
        ajax: {
            url: base_url + 'usuarios/listar',
            dataSrc: ''
            
        },
        columns: [
            { data: 'acciones' },
            { data: 'id' },
            { data: 'nombres' },
            { data: 'correo' },
            { data: 'telefono' },
            { data: 'direccion' },
            { data: 'perfil' },
            { data: 'fecha' }
        ],
        //para que este en español
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/es-ES.json'
        },
        //para que sea responsive
        responsive: true,
        //para que sea responsive
        order: [[1, 'asc']],
    } );

    //Boton de nuevo usuario
    btnNuevo.addEventListener("click", function () {
        title.textContent = "Nuevo Usuario";
        frm.querySelector('button[type="submit"]').innerHTML = '<i class="material-icons">save</i>Registrar';
        frm.id_usuario.value = '';
        frm.reset();
        frm.clave.removeAttribute('readonly');  
        myModal.show();
    });

    //Accion de registrar/editar usuario
    frm.addEventListener("submit", function (e) {
        e.preventDefault();
        if (
            frm.nombre.value == "" ||
            frm.apellido.value == "" ||
            frm.correo.value == "" ||
            frm.telefono.value == "" ||
            frm.direccion.value == "" ||
            frm.clave.value == "" ||
            frm.rol.value == ""
        ) {
            alertaPersonalizada("warning", "TODOS LOS CAMPOS SON REQUERIDOS");
        } else {
            const data = new FormData(frm);

            const http = new XMLHttpRequest();

            const url = base_url + 'usuarios/guardar';

            http.open("POST", url, true);

            http.send(data);

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let res = JSON.parse(this.responseText);
                    console.log(res)
                    alertaPersonalizada(res.tipo, res.mensaje);

                    if(res.tipo == 'success'){
                        frm.reset();
                        myModal.hide();
                        tblUsuarios.ajax.reload();
                    }
                }
            };
        }
    });
});
//Edita un usuario
function editar(id){
    const url = base_url + 'usuarios/editar/' + id;   
    const http = new XMLHttpRequest();
    http.open("GET", url, true); 
    http.send();
    http.onreadystatechange = function() { 
        if (this.readyState == 4 && this.status == 200) {
            
            const res = JSON.parse(this.responseText);
            
            title.textContent = "Editar Usuario";
            frm.querySelector('button[type="submit"]').innerHTML = '<i class="material-icons">save</i>Editar';
            frm.id_usuario.value = res.id;
            frm.nombre.value = res.nombre
            frm.apellido.value = res.apellido
            frm.correo.value = res.correo
            frm.telefono.value = res.telefono
            frm.direccion.value = res.direccion
            frm.clave.value = 'que no hay nada';
            frm.clave.setAttribute('readonly', 'readonly');
            myModal.show();
        }
        
    };
}

//Elimina un usuario
function eliminar(id){
    const url = base_url + 'usuarios/delete/'+id;
    eliminarRegistro('¿ESTA SEGURO DE ELIMINAR?', 'EL USUARIO NO SE ELIMINARÁ DE FORMA PERMANETE', 'Eliminar', url, tblUsuarios)
}
