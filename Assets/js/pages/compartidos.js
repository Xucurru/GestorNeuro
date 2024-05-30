const compartidos = document.querySelectorAll(".compartidos");
document.addEventListener("DOMContentLoaded", function () {
  compartidos.forEach((row) => {
    row.addEventListener("click", function (e) {
      let id_detalle = this.getAttribute("id");
      verDetalle(id_detalle);
    });
  });
});

//peticion ajax
function verDetalle(id_detalle) {
  const http = new XMLHttpRequest();
  const url = base_url + "compartidos/verDetalle/" + id_detalle;
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
    //   console.log(this.responseText);
      let res = JSON.parse(this.responseText);

      let html = ` <span class="mailbox-open-date">${res.fecha}</span>
      <h5 class="mailbox-open-title">
          Te ha compartido un archivo
      </h5>
      <div class="mailbox-open-author">
          <img src="${base_url +'/Assets/images/neuro.png'}" alt="">
          <div class="mailbox-open-author-info">
              <span class="mailbox-open-author-info-email d-block">${res.correo_archivo}</span>
              <span class="mailbox-open-author-info-to">Para <span class="badge badge-info align-self-center">${res.correo}</span></span>
          </div>
          <div class="mailbox-open-actions">
              <a href="#" class="btn btn-danger">Eliminar</a>
          </div>
      </div>
      <div class="mailbox-open-content-email">
          <p>Sino quiere recibir este archivo o quiere borrarlo de compartidos pulse en el boton de borrar</p>
          <div class="mailbox-open-content-email-attachments">
              <ul class="attachments-files-list list-unstyled">
                  <li class="attachments-files-list-item">
                      <span class="attachments-files-list-item-icon">
                          <i class="material-icons-outlined">insert_drive_file</i>
                      </span>
                      <span class="attachments-files-list-item-content">
                          <span class="attachments-files-list-item-title">${res.nombre}</span>
                          <span class="attachments-files-list-item-size">14 MB</span>
                      </span>
                      <a href="${base_url + 'Assets/archivos/'+res.id_carpeta + '/' + res.nombre}" download class="attachments-files-list-item-download-btn">
                          <i class="material-icons-outlined">
                              download
                          </i>
                      </a>
                  </li>
              </ul>
          </div>
      </div>
      <div class="mailbox-open-content-reply">
          <div id="reply-editor"></div>
      </div>`;
      document.querySelector('#content-info').innerHTML = html;
    }
  };
}
