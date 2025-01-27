document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("formRegistro").addEventListener("submit", function(event) {
      event.preventDefault(); // Prevenir el envío por defecto

     
      let nombreField = document.getElementById("name");
      let emailField = document.getElementById("email");
      let ocupacionField = document.getElementById("ocupacion");
      let telefonoField = document.getElementById("tel");
      let fecha_nacimientoField = document.getElementById("born");

      let nombre = nombreField.value.trim();
      let email = emailField.value.trim();
      let ocupacion = ocupacionField.value.trim();
      let telefono = telefonoField.value.trim();
      let fecha_nacimiento = fecha_nacimientoField.value.trim();

      let errorNombre = "";
      let errorEmail = "";
      let errorOcupacion = "";
      let errorTelefono = "";
      let errorBorn = "";

      if (nombre === "") {
        errorNombre = 'Complete el Nombre.';
        nombreField.classList.add("error");
      } else {
        nombreField.classList.remove('error');
      }

      if (email === "") {
        errorEmail = 'Complete el Email.';
        emailField.classList.add('error');
      } else {
        emailField.classList.remove('error');
      }

      if (ocupacion === "") {
        errorOcupacion = 'Complete la Ocupación.';
        ocupacionField.classList.add('error');
      } else {
        ocupacionField.classList.remove('error');
      }

      if (telefono === "") {
        errorTelefono = 'Complete el Teléfono.';
        telefonoField.classList.add('error');
      } else {
        telefonoField.classList.remove('error');
      }

      if (fecha_nacimiento === "") {
        errorBorn = 'Complete la Fecha de nacimiento.';
        fecha_nacimientoField.classList.add('error');
      } else {
        fecha_nacimientoField.classList.remove('error');
      }

      document.getElementById('errorNombre').textContent = errorNombre;
      document.getElementById('errorEmail').textContent = errorEmail;
      document.getElementById('errorOcupacion').textContent = errorOcupacion;
      document.getElementById('errorTelefono').textContent = errorTelefono;
      document.getElementById('errorBorn').textContent = errorBorn;

      if (errorNombre === "" && errorEmail === "" && errorOcupacion === "" && errorTelefono === "" && errorBorn === "") {

        let confirmationMessage = document.getElementById('confirmationMessage');
        confirmationMessage.textContent = 'Formulario enviado satisfactoriamente!';
      
        
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'registro.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
          if (xhr.status === 200) {
            
          } else {
            document.getElementById('resultado').innerHTML = 'Error: ' + xhr.statusText;
          }
        };

        xhr.send('nombre=' + encodeURIComponent(nombre) + 
                 '&email=' + encodeURIComponent(email) + 
                 '&ocupacion=' + encodeURIComponent(ocupacion) + 
                 '&telefono=' + encodeURIComponent(telefono) + 
                 '&fecha_nacimiento=' + encodeURIComponent(fecha_nacimiento));

        //Limpiar formulario
        nombreField.value = '';
        emailField.value = '';
        ocupacionField.value = '';
        telefonoField.value = '';
        fecha_nacimientoField.value = '';

        setTimeout(function() {
          console.log('Temporizador ejecutado, borrando mensaje');
          confirmationMessage.textContent = '';
        }, 4000);
    } else {
      event.preventDefault();
    }
    
  });
});
        
