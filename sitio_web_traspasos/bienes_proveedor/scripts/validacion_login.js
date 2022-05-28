function validarCredenciales() {

        userName = document.getElementById("userName").value;
        openSesame = document.getElementById("pwd").value
        var parametros = 
        {
            "userName" : userName,
            "password" : openSesame
        }

        $.ajax({
            data : parametros,
            dataType : 'TEXT',
            url : 'validacion/',
            type : 'POST',
            beforeSend : function () {
                console.log("antes de enviar");
            },
            error : function () {
                console.log("error, verifique el comando de conexion");
            },
            complete : function () {
                console.log("comprobacion completada");
            },
            success : function (valores) {
                //console.log(valores);

                alert("redirigiendo a pagina de menu" + valores);
                
                //var direccion = "escaneo/?uuid="+uuid;
                //location.href = direccion;
                $("#co").html(valores);

            }
        });


    }