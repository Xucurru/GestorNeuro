const btnUpload = document.querySelector("#btnUpload");

const file = document.querySelector("#file");
const id =
  window.location.pathname.split("/")[
    window.location.pathname.split("/").length - 1
  ];
let idArc;
//clases
const compartir = document.querySelectorAll(".compartir");
const moveto = document.querySelectorAll(".moveto");
const moverA = document.querySelectorAll(".moverA");

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
const modalMoveto = document.querySelector("#modalMoverto");
const myModal4 = new bootstrap.Modal(modalMoveto);

//ids varios
const container_archivos = document.querySelector("#container-archivos");
const tblDetalle = document.querySelector("#tblDetalle tbody");
const tblDetalleT = document.querySelector("#tblDetalle");
const tblMove = document.querySelectorAll("#tblMove");

btnUpload.addEventListener("click", function () {
  file.click();
});

file.addEventListener("change", function (e) {
  const data = new FormData();
  data.append("file", e.target.files[0]);
  data.append("id_carpeta", id);
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

compartir.forEach((enlace) => {
  enlace.addEventListener("click", function (e) {
    e.preventDefault();
    compartirArchivo(e.target.id, e.target.getAttribute("carpeta"));
  });
});

function compartirArchivo(id, carpeta) {
  id_archivo.value = id;
  id_carpeta.value = carpeta;

  verArchivos();

  setTimeout(function () {
    let chekboxs = document.querySelectorAll(".form-check-input");
    chekboxs.forEach((chek) => {

      if (!chek.id.includes(id)) {
        chek.checked = false;
      }
    });
  }, 50);

  myModal3.show();
}
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
  language: {
    errorLoading: function () {
      return "Por favor, ingresa al menos un carácter";
    },
    maximumSelected: function (args) {
      return "Solo puedes agregar 5 usuarios a la vez";
    },
    inputTooShort: function () {
      return "Por favor, ingresa al menos un carácter";
    },
    searching: function () {
      return "Buscando...";
    },
    noResults: function () {
      return "No se encontraron resultados";
    },
  },
});

function verArchivos() {
  const http = new XMLHttpRequest();
  const url = base_url + "archivos/verArchivos/" + id_carpeta.value;

  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);
      if (res.length > 0) {
        tblDetalleT.style.display = "block";
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
      } else {
        html = `<div class="alert alert-custom alert-indicator-right indicator-warning" role="alert">
          <div class="alert-content">
              <span class="alert-title">Carpeta Vacia!</span>
              <span class="alert-text">La carpeta que estas intentando compartir se encuentra vacia</span>
          </div>
      </div>`;

        tblDetalle.innerHTML = "";
        tblDetalleT.style.display = "none";
      }
      container_archivos.innerHTML = html;
      myModal2.hide();
      myModal3.show();
    }
  };
}

function cargarDetalle(idCarpeta) {
  const http = new XMLHttpRequest();
  const url = base_url + "archivos/verDetalle/" + idCarpeta;

  http.open("GET", url, true);
  http.send();

  http.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        let detalles = JSON.parse(this.responseText);

        let html = "";
        detalles.forEach((detalle) => {
          html +=
            "<tr>" +
            "<td>" +
            acortarString(detalle.nombre, 50) +
            "</td>" +
            "<td>" +
            detalle.correo +
            "</td>" +
            '<td><button class="btn btn-danger btn-sm" idD="' +
            detalle.id +
            '" type="button" onclick="eliminarCompartido(this)">Eliminar</button></td>' +
            "</tr>";
        });

        if (detalles.length === 0) {
          html =
            "<tr>" + '<td colspan="3">Ningún archivo compartido</td>' + "</tr>";
        }

        tblDetalle.innerHTML = html;
        myModal2.hide();
        myModal3.show();
      } else {
        console.error("Error al cargar los detalles: " + this.statusText);
      }
    }
  };
}

function eliminarCompartido(button) {
  let id_detalle = button.getAttribute("idd");

  const http = new XMLHttpRequest();
  const url = base_url + "compartidos/delete/" + id_detalle;
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);
      alertaPersonalizada(res.tipo, res.mensaje);

      if (res.tipo == "success") {
        verArchivos();
      }
    }
  };
}

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
        let res = JSON.parse(this.responseText);
        alertaPersonalizada(res.tipo, res.mensaje);

        if (res.tipo == "success") {
          verArchivos();
        }
      }
    };
  }
});

if (moveto) {
  moveto.forEach((mover) => {
    mover.addEventListener("click", function (e) {
      e.preventDefault();
      let ida = e.target.getAttribute("ida");
      let idc = e.target.getAttribute("idc");

      if (ida == null) {
        ida = e.target.parentNode.getAttribute("ida");
        idc = e.target.parentNode.getAttribute("idc");
      }
      idArc = ida;
      mostrarCarpetas(idc);
      myModal4.show();
    });
  });
}

function mostrarCarpetas(idc) {
  $.ajax({
    url: base_url + "archivos/mostrarCarpetasMenos/" + idc,
  });
  if ($.fn.DataTable.isDataTable('#tblMove')) {
    $('#tblMove').DataTable().destroy();
}
 $("#tblMove").DataTable({
    ajax: {
      url: base_url + "archivos/mostrarCarpetasMenos/" + idc,
      dataSrc: "",
    },
    columns: [{ data: "acciones" },{ data: "nombre" }],
    rowCallback: function (row, data) {
      // Agregar a los tr
      $(row).addClass("moverA");
      $(row).attr("carpeta", data.id);
      $(row).attr("id_archivo", idc);
    },
    language: {
      url: "https://cdn.datatables.net/plug-ins/2.0.5/i18n/es-ES.json",
    },
    responsive: true,
    order: [[0, "asc"]],
  });


}

function moverAs(idc){
  const data = new FormData();
  const http = new XMLHttpRequest();
  const url = base_url + "archivos/moverA";
  http.open("POST", url, true);
  data.append('id_archivo', idArc);
  data.append('id_carpeta', idc);
  http.send(data);
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let res = JSON.parse(this.responseText);
      alertaPersonalizada(res.tipo, res.mensaje);

      if(res.tipo == "success"){
        setTimeout(function(){
          window.location.reload();
        },2000)
      }
    }
  };
}