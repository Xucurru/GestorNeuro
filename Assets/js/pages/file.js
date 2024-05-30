//botones
const btnUpload = document.querySelector("#btnUpload");
const btnUpload2 = document.querySelector("#addDropdownLink");

const btnNuevaCarpeta = document.querySelector("#btnNuevaCarpeta");
const btnSubirArchivo = document.querySelector("#btnSubirArchivo");
const btnSubir = document.querySelector("#btnSubir");
const btnVer = document.querySelector("#btnVer");
const btnCompartir = document.querySelector("#btnCompartir");

//modals
const modalFile = document.querySelector("#modalFile");
const myModal = new bootstrap.Modal(modalFile);
const modalCarpeta = document.querySelector("#modalCarpeta");
const myModal1 = new bootstrap.Modal(modalCarpeta);
const frmCarpeta = document.querySelector("#frmCarpeta");
const modalCompartir = document.querySelector("#modalCompartir");
const myModal2 = new bootstrap.Modal(modalCompartir);
const modalUsuarios = document.querySelector("#modalUsuarios");
const myModal3 = new bootstrap.Modal(modalUsuarios);
const id_archivo = document.querySelector("#id_archivo");
const frmCompartir = document.querySelector("#frmCompartir");

//id varios
const id_carpeta = document.querySelector("#id_carpeta");
const title_compartir = document.querySelector("#title-compartir");
const usuarios = document.querySelector("#usuarios");
const file = document.querySelector("#file");
const container_archivos = document.querySelector("#container-archivos");
const tblDetalle = document.querySelector("#tblDetalle tbody");

//clases
const carpetas = document.querySelectorAll(".carpetas");
const compartir = document.querySelectorAll(".compartir");

//acciones botones
document.addEventListener("DOMContentLoaded", function () {
  //funcion mostrar modal principal
  btnUpload.addEventListener("click", function () {
    myModal.show();
  });
  btnUpload2.addEventListener("click", function () {
    myModal.show();
  });
  //funcion mostrar modal crear carpeta
  btnNuevaCarpeta.addEventListener("click", function () {
    myModal.hide();
    myModal1.show();
  });
  //funcion para crear carpeta
  frmCarpeta.addEventListener("submit", function (event) {
    event.preventDefault();

    if (frmCarpeta.nombre.value == "") {
      alertaPersonalizada("warning", "Se necesita un nombre para la carpeta");
    } else {
      const data = new FormData(frmCarpeta);
      const http = new XMLHttpRequest();
      const url = base_url + "admin/crearcarpeta";
      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);

          if (res.tipo == "success") {
            setTimeout(() => {
              window.location.reload();
            }, 1500);
          }
        }
      };
    }
  });
  //Mostrar input de tipo file
  btnSubirArchivo.addEventListener("click", function () {
    myModal.hide();
    file.click();
  });

  //Subir archivo
  file.addEventListener("change", function (e) {
    const data = new FormData();
    data.append("file", e.target.files[0]);
    data.append("id_carpeta", id_carpeta.value);
    const http = new XMLHttpRequest();
    const url = base_url + "admin/subirarchivo";
    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let res = JSON.parse(this.responseText);
        alertaPersonalizada(res.tipo, res.mensaje);

        if (res.tipo == "success") {
          setTimeout(() => {
            window.location.reload();
          }, 1500);
        }
      }
    };
  });

  carpetas.forEach((carpeta) => {
    carpeta.addEventListener("click", function (e) {
      title_compartir.textContent = e.target.textContent;
      id_carpeta.value = e.target.id;
      myModal2.show();
    });
  });
  //Mostrar input de tipo file
  btnSubir.addEventListener("click", function () {
    myModal2.hide();
    file.click();
  });
  //Ver un archivo

  btnVer.addEventListener("click", function () {
    window.location = base_url + "admin/ver/" + id_carpeta.value;
  });

  //Compartir archivos entre usuarios
  compartir.forEach((enlace) => {
    enlace.addEventListener("click", function (e) {
      compartirArchivo(e.target.id);
    });
  });

  let menos = Array.from(
    document.querySelectorAll(".select2-selection__choice")
  ).map(function (element) {
    return element.value;
  });
  //Select de los usuario con filtro
  $(".js-states").select2({
    placeholder: "Buscar y agregar Usuarios",
    maximumSelectionLength: 5,
    minimunInputLength: 1,
    dropdownParent: $("#modalUsuarios"),
    ajax: {
      url: base_url + "archivos/getUsuarios",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          q: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: data,
        };
      },
      cache: true,
    },
  });
  //submit de compartir
  frmCompartir.addEventListener("submit", function (e) {
    e.preventDefault();
    if (usuarios.value == "") {
      alertaPersonalizada("warning", "DEBE INSERTAR ALGUN USUARIO");
    } else {
      const data = new FormData(frmCompartir);
      const http = new XMLHttpRequest();
      const url = base_url + "archivos/compartir";
      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          let res = JSON.parse(this.responseText);
         alertaPersonalizada(res.tipo, res.mensaje);

         if (res.tipo == "success") {
            id_archivo.value = "";
            myModal3.hide();
           $(".js-states").val(null).trigger("change");
           }
        }
      };
    }
  });
  //Compartir archivos por carpetas
  btnCompartir.addEventListener("click", function () {
    verArchivos();
  });
});

function compartirArchivo(id) {
  id_archivo.value = id;
  myModal3.show();
}

//Muestra los archivo de una carpeta en el modalUsuarios
function verArchivos() {
  const http = new XMLHttpRequest();
  const url = base_url + "archivos/verArchivos/" + id_carpeta.value;
  console.log(url);
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);
      console.log(res.length);
      html = "";
      res.forEach((archivo) => {
        html += `<div class="form-check">
        <input class="form-check-input" type="checkbox" id="flexCheckChecked_${archivo.id}" value="${archivo.id}" name="archivos[]" checked="">
        <label class="form-check-label" for="flexCheckChecked_${archivo.id}">
            ${archivo.nombre}
        </label>
    </div>`;
      });
      cargarDetalle(id_carpeta.value);
      if (res.length > 0) {
      } else {
        html = `<div class="alert alert-custom alert-indicator-right indicator-warning" role="alert">
        <div class="alert-content">
            <span class="alert-title">Carpeta Vacia!</span>
            <span class="alert-text">La carpeta que estas intentando compartir se encuentra vacia</span>
        </div>
    </div>`
      }
      container_archivos.innerHTML = html;
      myModal2.hide();
      myModal3.show();
    }
  };
}

//Muestra de 1 archivo o carpeta los usuarios ya compartidos
function cargarDetalle(id_carpeta){
  const http = new XMLHttpRequest();
  const url = base_url + "archivos/verDetalle/" + id_carpeta;
  console.log(url);
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);
      console.log(res.length);
      html = "";
      res.forEach((archivo) => {
        html += `<tr>
        <td>${acortarString(archivo.nombre, 26)}</td>
        <td>${archivo.correo}</td>
        <td><button class="btn btn-danger btn-sm" type="button">Eliminar</button></td>
    </tr>`;
      });
      if (res.length > 0) {
      } else {
        html = `<tr>
        <td colspan="3">Ningún archivo compartido</td>
    </tr>`
      }
      tblDetalle.innerHTML = html;
      myModal2.hide();
      myModal3.show();
    }
  };
}

//Acorta la longitud de un string
function acortarString(str, tam) {
  if (str.length > tam) {
      return str.substring(0, 26) + "...";
  } else {
      return str;
  }
}
