<!DOCTYPE html>
<html>
<head>
    <title>Pago recibido. MUNICIPIO DE GUADALUPE N.L.</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>

    <body>
        <script src="{{ asset('jquery.js') }}"></script>
        <form name="form1" id="form1" method="post" action="">
            <p><img src="{{ asset('Escudo-armas-pago-predial-2.jpg') }}" border="0" alt="Gracias al pago de su Impuesto Predial, Guadalupe avanza mejorando su ciudad."></p>
            <p style="font-weight: bold; font-size: 22pt; font-family: verdana; color: gray;">Se registr&aacute;  su pago en nuestro Sistema.</p>
            <p style="font-weight: bold; font-size: 22pt; font-family: verdana; color: gray;">
               <img border="0" src="{{ asset('logo_bancomer.gif') }}" width="171" height="35">
            </p>
            <table border="0" style="font-size: 8pt; font-family: verdana">
                <tr>
                    <td>El d&iacute;a:</td>
                    <td style="color: red">{{ $resultados['hoy']}}</td>
                </tr>
                <tr>
                    <td>Recibo de pago #:</td>
                    <td style="color: red">{{$resultados['wfoliorec']}}</td>
                </tr>
                <tr>
                    <td>Caja :</td>
                    <td style="color: red">{{ $resultados['wcaja']}}</td>
                </tr>
                <tr>
                    <td>Por el Concepto de:</td>
                    <td style="color: red">{{ $resultados['wdescconcepto']}}</td>
                </tr>
                <tr>
                    <td>de :</td>
                    <td style="color: red">{{ '$'.number_format($resultados['wimporte'],2)}}</td>
                </tr>
                <tr>
                    <td>Con Expediente # :</td>
                    <td style="color: red">{{ $resultados['Expe']}}</td>
                </tr>
                <tr>
                    <td>Con Autorizaci&oacute;n Bancaria No.:</td>
                    <td style="color: red">{{ $resultados['noperacion']}}</td>
                </tr>
            </table>
            <br><br>
            <table border="0" style="font-size: 8pt; font-family: verdana">
                <tr>
                    <td>Correo Electr&oacute;nico: <input type="email" name="correo" id="correo" style="width: 250px;" value=""></td>
                    <td><input name="btnEnviar" id="btnIEnviar" type="button" class="button" value="Enviar Comprobante" onClick="enviar_comprobante()"></td>
                </tr>
            </table>
            <br><br>
            <p>
                <input name="Submit" type="button" onclick="javascript:window.close();" value="Cerrar">
                <input name="btnImprimir" id="btnImprimir" type="button" class="button" value="Imprimir" onClick="comprobate_pdf()">
            </p>
        </form>
    
        <script>
            function imprime() {
                window.print()
            }
    
            function enviar_comprobante() {
                let expe =   $resultados['Expe'] ;
            //   let expe = '{{  $resultados['Expe'] }}';
              //let expe = '01001012';
              let correo = $("#correo").val();
                if (correo == "") {
                    alert('Favor de escribir su correo electrónico');
                    return false;
                }
    
                $.ajax({
                    type: "POST",
                    url: "http://webservice.guadalupe.gob.mx/predial/pago/pdf",
                    data: { "expediente": expe, "correo": correo },
                    success: function(data) {
                        console.log(data);
                        alert('Se ha enviado el comprobante de pago a su correo electrónico');
                        window.open(data);
                    }
                });
            }
    
            function comprobate_pdf() {
                 let expe =   $resultados['Expe'] ;
               // let expe = '01001012';
    
                $.ajax({
                    type: "POST",
                    url: "http://webservice.guadalupe.gob.mx/predial/pago/pdf",
                    data: { "expediente": expe },
                    success: function(data) {
                        window.open(data);
                    }
                });
            }
        </script>
    </body>
    </html>