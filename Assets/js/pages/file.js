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
const tblDetalleT = document.querySelector("#tblDetalle");

//clases
const carpetas = document.querySelectorAll(".carpetas");
const compartir = document.querySelectorAll(".compartir");
const eliminar = document.querySelectorAll(".eliminar");
const cards = document.querySelectorAll(".card");
const archivos = document.querySelectorAll(".archivos");
const compartidos = document.querySelectorAll(".compartido");
const restaurars = document.querySelectorAll(".restaurar");
const eliminarDef = document.querySelectorAll(".eliminarDef");


//acciones botones
document.addEventListener("DOMContentLoaded", function () {
  //funcion mostrar modal principal
  btnUpload.addEventListener("click", function () {
    myModal1.show();
  });
  btnUpload2.addEventListener("click", function () {
    myModal.show();
  });
  if (btnNuevaCarpeta) {
    //funcion mostrar modal crear carpeta
    btnNuevaCarpeta.addEventListener("click", function () {
      myModal.hide();
      myModal1.show();
    });
  }
  if (frmCarpeta) {
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
  }
  if (btnSubirArchivo) {
    //Mostrar input de tipo file
    btnSubirArchivo.addEventListener("click", function () {
      myModal.hide();
      file.click();
    });
  }
  if (file) {
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
  }
  carpetas.forEach((carpeta) => {
    carpeta.parentNode.parentNode.addEventListener("click", function (e) {
      title_compartir.textContent = carpeta.textContent;
      id_carpeta.value = carpeta.id;
      myModal2.show();
    });
  });
  if (btnSubir) {
    //Mostrar input de tipo file
    btnSubir.addEventListener("click", function () {
      myModal2.hide();
      file.click();
    });
  }
  //Ver un archivo
  if (btnVer) {
    btnVer.addEventListener("click", function () {
      window.location = base_url + "admin/ver/" + id_carpeta.value;
    });
  }

  if (compartir) {
    //Compartir archivos entre usuarios
    compartir.forEach((enlace) => {
      enlace.addEventListener("click", function (e) {
        e.preventDefault();
        if(e.target.getAttribute("carpeta") == null){
          compartirArchivo(e.target.parentNode.id, e.target.parentNode.getAttribute("carpeta"));
        }else{
          compartirArchivo(e.target.id, e.target.getAttribute("carpeta"));
        }
        
      });
    });

    if (eliminar) {
      //Compartir archivos entre usuarios
      eliminar.forEach((enlace) => {
        enlace.addEventListener("click", function (e) {
          e.preventDefault();
          id = e.target.getAttribute("ida");
          let url = base_url + "archivos/papelera/" + id;
          eliminarRegistro(
            "¿Estas seguro de eliminar?",
            "El archivo se enviará a la papelera",
            "Eliminar",
            url,
            "ventana"
          );
        });
      });
    }
  }

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
  if (frmCompartir) {
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
            let res = JSON.parse(this.responseText);
            alertaPersonalizada(res.tipo, res.mensaje);

            if (res.tipo == "success") {
              verArchivos();
            }
          }
        };
      }
    });
  }

  if (btnCompartir) {
    //Compartir archivos por carpetas
    btnCompartir.addEventListener("click", function () {
      verArchivos();
    });
  }
  if (archivos) {
    document.addEventListener("click", function (event) {
      // Verifica si el clic ocurrió fuera de los elementos de archivo
      let isClickInside = false;
      archivos.forEach(function (archivo) {
        if (archivo.contains(event.target)) {
          isClickInside = true;
        }
      });

      if (!isClickInside) {
        archivos.forEach(function (archivo) {
          let puntos = archivo.querySelector(
            ".file-manager-recent-file-actions"
          );
          let menu = archivo.querySelector(".dropdown-menu-end");
          if (puntos.classList.contains("show")) {
            puntos.classList.remove("show");
            puntos.setAttribute("aria-expanded", false);
            menu.style.position = "";
            menu.style.inset = "";
            menu.style.margin = "";
            menu.style.transform = "";
            menu.classList.remove("show");
          }
        });
      }
    });

    archivos.forEach(function (archivo) {
      archivo.addEventListener("click", function () {
        let puntos = archivo.querySelector(".file-manager-recent-file-actions");
        let menu = archivo.querySelector(".dropdown-menu-end");

        //cerrar los otros menus
        archivos.forEach(function (otherArchivo) {
          if (otherArchivo !== archivo) {
            let otherPuntos = otherArchivo.querySelector(
              ".file-manager-recent-file-actions"
            );
            let otherMenu = otherArchivo.querySelector(".dropdown-menu-end");
            if (otherPuntos.classList.contains("show")) {
              otherPuntos.classList.remove("show");
              otherPuntos.setAttribute("aria-expanded", false);
              otherMenu.style.position = "";
              otherMenu.style.inset = "";
              otherMenu.style.margin = "";
              otherMenu.style.transform = "";
              otherMenu.classList.remove("show");
            }
          }
        });
        if (puntos.classList.contains("show")) {
          puntos.classList.remove("show");
          puntos.setAttribute("aria-expanded", false);
          menu.style.position = "";
          menu.style.inset = "";
          menu.style.margin = "";
          menu.style.transform = "";
          menu.classList.remove("show");
        } else {
          puntos.classList.add("show");
          puntos.setAttribute("aria-expanded", true);

          menu.classList.add("show");
          menu.style.position = "absolute";
          menu.style.inset = "0px auto auto 0px";
          menu.style.margin = "0px 0px 0px 0px";
          menu.style.transform = "translate(50%, 50px)";
        }
      });
    });
  }
  if (cards) {
    cards.forEach(function (card) {
      let links = card.querySelectorAll("a");
      links.forEach(function (link) {
        link.addEventListener("click", function (event) {
          if (link.parentNode.tagName == "LI") {
          } else {
            event.preventDefault();
          }
        });
      });
    });
  }
});

function compartirArchivo(id, carpeta) {
  id_archivo.value = id;
  id_carpeta.value = carpeta;

  verArchivos();

  setTimeout(function () {
    let chekboxs = document.querySelectorAll(".form-check-input");
    chekboxs.forEach((chek) => {
      console.log();
      if (!chek.id.includes(id)) {
        chek.checked = false;
      }
    });
  }, 50);

  myModal3.show();
}

//Muestra los archivo de una carpeta en el modalUsuarios
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

//Muestra de 1 archivo o carpeta los usuarios ya compartidos
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

if (compartidos) {
  compartidos.forEach((compartido) => {
    compartido.addEventListener("click", function (event) {
      event.preventDefault();
      let cor = event.target.getAttribute("correo");
      let nom = event.target.getAttribute("nombre");
      let pasar = event.target;
      if (cor == null) {
        nom = event.target.parentNode.getAttribute("nombre");
        cor = event.target.parentNode.getAttribute("correo");
        pasar = event.target.parentNode;
      }

      Swal.fire({
        title: "Quieres dejar de compartir?",
        text: "El archivo " + nom + ", se dejara de compartir con " + cor,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          eliminarCompartido(pasar);
        }
      });
    });
  });
}

if (restaurars) {
  restaurars.forEach((restaurar) => {
    restaurar.addEventListener("click", function (event) {
      event.preventDefault();
      let idr = event.target.getAttribute("idr");

      if (idr == null) {
        idr = event.target.parentNode.getAttribute("idr");
      }
      console.log(idr);
      const http = new XMLHttpRequest();
      const url = base_url + "eliminados/restaurar/" + idr;

      http.open("GET", url, true);
      http.send();

      http.onreadystatechange = function () {
        if (this.readyState == 4) {
          if (this.status == 200) {
            let res = JSON.parse(this.responseText);
            alertaPersonalizada(res.tipo, res.mensaje);

            setTimeout(function () {
              window.location.reload();
            }, 1500);
          }
        }
      };
    });
  });
}

if (eliminarDef) {
  eliminarDef.forEach((eliminarD) => {
    eliminarD.addEventListener("click", function (event) {
      event.preventDefault();
      let idr = event.target.getAttribute("ided");
      let nom = event.target.getAttribute("nombre");

      if (idr == null) {
        idr = event.target.parentNode.getAttribute("ided");
        nom = event.target.parentNode.getAttribute("nombre");
      }

      Swal.fire({
        title: "Quieres eliminar definitivamente este archivo?",
        text: "El archivo " + nom + ", dejara de existir ",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          
          const http = new XMLHttpRequest();
          const url = base_url + "eliminados/eliminarDef/" + idr;
          http.open("GET", url, true);
          http.send();
          http.onreadystatechange = function () {
            if (this.readyState == 4) {
              if (this.status == 200) {
                let res = JSON.parse(this.responseText);
                alertaPersonalizada(res.tipo, res.mensaje);

                setTimeout(function () {
                  window.location.reload();
                }, 1500);
              }
            }
          };
        }
      });
    });
  });
}


//cambia el active si es /archivos
if (window.location.href.includes("archivos")) {
  var ul = document.querySelector("ul.list-unstyled");

  ul.querySelector(".active").classList.remove("active");

  var lis = ul.querySelectorAll("li");

  lis.forEach(function (li) {
    var a = li.querySelector("a");
    if (a && a.textContent.trim() === "Todos") {
      a.classList.add("active");
    }
  });
} else if (window.location.href.includes("eliminados")) {
  btnUpload.style.display = "none";
  var ul = document.querySelector("ul.list-unstyled");

  ul.querySelector(".active").classList.remove("active");

  var lis = ul.querySelectorAll("li");

  lis.forEach(function (li) {
    var a = li.querySelector("a");
    if (a && a.textContent.trim() == "Eliminados") {
      a.classList.add("active");
    }
  });
} else if (window.location.href.includes("compartido")) {
  var ul = document.querySelector("ul.list-unstyled");
  btnUpload.style.display = "none";
  ul.querySelector(".active").classList.remove("active");

  var lis = ul.querySelectorAll("li");

  lis.forEach(function (li) {
    var a = li.querySelector("a");
    if (a && a.textContent.trim() == "Compartido") {
      a.classList.add("active");
    }
  });
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
        if (button.getAttribute("correo")) {
          setTimeout(function () {
            window.location.reload();
          }, 1500);
        } else {
          verArchivos();
        }
      }
    }
  };
}
