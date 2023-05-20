</main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <script>
    $(document).ready(function(){
      //Hacemos referencia al elemento via UD
      $("#tabla_id").DataTable({
        //Se añaden las propiedades

        //Tamaño de registros a mostrar por pagina
        "pageLength":3, 

        //Personlizamos todo lo que vamos a mostrar
        lengthMenu:[
          //Como se va a mostrar el paginado o numero de registros
          [3,10,25,50],
          [3,10,25,50]
        ],

        "language":{
          //Lenguaje del DataTable
          "url":"https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        }
      });
    });
  </script>
  <script>
    //Mostrar el mensaje de confirmación grafico
    function borrar(id){
        Swal.fire({
            //Mensaje a mostrar
            title: '¿Quieres borrar el registro?',
            
            //Mostrar boton de cancelar
            showCancelButton: true,
            //Mensaje de boton de aceptar
            confirmButtonText: 'Si, Borrar',
            }).then((result) => {
                if (result.isConfirmed) {
                    //Si se pulsa el boton de aceptar se redirecciona al index enviando la ID para ejecutar el metodo de eliminar
                    window.location="index.php?txtID="+id;
                } 
        })

        /*
        Swal.fire({
            //Mensaje a mostrar
            title: '¿Quieres borrar el registro?',
            //Mostrar boton de denegar
            showDenyButton: true,
            //Mostrar boton de cancelar
            showCancelButton: true,
            //Mensaje de boton de aceptar
            confirmButtonText: 'Si',
            //Mensaje de boton de denegar
            denyButtonText: `No`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            /*if (result.isConfirmed) {
                //Mensaje al pulsar de boton de aceptar
                Swal.fire('Saved!', '', 'success')

                //window.location="index.php?txtID="+id;
            } else if (result.isDenied) {
                //Mensaje al pulsar de boton de aceptar
                Swal.fire('Changes are not saved', '', 'info')
            }
        })*/
        //index.php?txtID=
    }

    function info(){
      Swal.fire('Página Web de práctica creada por: Faustino Cerdán Gomis alias Fauszdev');
    }
</script>
</body>

</html>