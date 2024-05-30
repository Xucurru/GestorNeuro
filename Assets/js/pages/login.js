/*JS de la vista principal*/
//alertaPersonalizada('success', 'Hola');

const frm1 = document.querySelector("#formulario");
const frmRegistro = document.querySelector("#frmRegistro");
const correo = document.querySelector("#correo");
const clave = document.querySelector("#clave");
const registro = document.querySelector('#registro');
const modalRegistro = document.querySelector('#modalRegistro')
const myModal = new bootstrap.Modal(modalRegistro);
;
document.addEventListener("DOMContentLoaded", function () {
  frm1.addEventListener("submit", function (event) {
    event.preventDefault();

    //Si los campos estan vacios salta una alerta
    if (correo.value == "" || clave.value == "") {
      alertaPersonalizada("warning", "Todo los campos con *  son requeridos");
      //Sino se realiza una peticion AJAX
    } else {
      const data = new FormData(frm1);
      const http = new XMLHttpRequest();

      const url = base_url + "principal/validar";

      http.open("POST", url, true);

      http.send(data);

      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            let timerInterval;
            Swal.fire({
              title: res.mensaje,
              html: "Redireccionando en <b></b>.",
              timer: 2000,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                  timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
              },
              willClose: () => {
                clearInterval(timerInterval);
              },
            }).then((result) => {
              if (result.dismiss === Swal.DismissReason.timer) {
                window.location = base_url + "admin";
              }
            });
          }
        }
      };
    }
  });

  //Mostrar modal registro
  registro.addEventListener('click', function(event){
    event.preventDefault();
    myModal.show();
  })

  frmRegistro.addEventListener("submit", function (event) {
    event.preventDefault();

    //Si los campos estan vacios salta una alerta
    if (frmRegistro.nombre.value == "" || frmRegistro.apellido.value == "" || frmRegistro.correo.value == "" || frmRegistro.telefono.value == "" || frmRegistro.clave.value == "" || frmRegistro.direccion.value == "" ) {
      alertaPersonalizada("warning", "Necesitas completar todos los campos");
      //Sino se realiza una peticion AJAX
    } else if(frmRegistro.telefono.value.length != 9){
      alertaPersonalizada("warning", "El teléfono no es válido")
    }
    else {
      const data = new FormData(frmRegistro);
      const http = new XMLHttpRequest();

      const url = base_url + "principal/validarR";

      http.open("POST", url, true);

      http.send(data);

      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            let timerInterval;
            Swal.fire({
              title: res.mensaje,
              html: "Redireccionando en <b></b>.",
              timer: 2000,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                  timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
              },
              willClose: () => {
                clearInterval(timerInterval);
              },
            }).then((result) => {
              if (result.dismiss === Swal.DismissReason.timer) {
                window.location = base_url + "admin";
              }
            });
          }
        }
      };
    }
  });

});
