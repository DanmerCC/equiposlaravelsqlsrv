<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 25px;
            }

            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;

                /** Extra personal styles **/
                background-color: #ffffff;
                color: rgb(0, 0, 0);
                text-align: left;
                line-height: 35px;
            }

            footer {
                position: fixed;
                bottom: -60px;
                left: 0px;
                right: 0px;
                height: 50px;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px;
            }

            table * {
                border: 1px solid rgba(217, 216, 216, 0.392);
            }
            table {
                width: 100%
            }

            .cell{
                border: 2px solid rgb(0, 0, 0);
                min-height: 5cm
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <img height="50px" src="./logo2.jpeg" alt="" srcset="">
            Expertis  SAC <br>
            Departamento de Sistemas
        </header>

        <footer>
            Copyright &copy; <?php echo date("Y");?>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <br>
            <br>
            <table>
                <thead>
                    <th colspan="11">ACTA DE ENTREGA DE HARDWARE Y SOFTWARE</th>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="11">Datos de asignacion</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="">Fecha</td>
                        <td class="cell">
                            {{$fecha??""}}
                        </td>
                        <td></td>
                        <td class="">Local</td>
                        <td colspan="3" class="cell">{{$local??""}}</td>
                        <td>Condicion</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="height: 30pt">
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cell"></td>
                        <td class="cell"></td>
                        <td></td>
                    </tr>
                    <tr style="height: 30pt">
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cell"></td>
                        <td class="cell"></td>
                        <td></td>
                    </tr>
                    <tr style="height: 30pt">
                        <td colspan="3">Responsable</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cell"></td>
                        <td class="cell"></td>
                        <td></td>
                    </tr>
                    <tr style="height: 30pt">
                        <td>&nbsp;</td>
                        <td>Apellidos</td>
                        <td class="cell">{{ $apellidos??"" }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cell"></td>
                        <td class="cell"></td>
                        <td></td>
                    </tr>
                    <tr style="height: 30pt">
                        <td>&nbsp;</td>
                        <td>Nombres</td>
                        <td class="cell">{{$nombres??""}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cell"></td>
                        <td class="cell"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Fecha de Entrega</td>
                        <td class="cell"></td>
                        <td>Numero DNI</td>
                        <td colspan="2" class="cell">
                            {{$dni??""}}
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Departamento</td>
                        <td>LIMA/LIMA/LIMA</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Tipo de Asignación</td>
                        <td>{{ $tipoasignacion??"" }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <table>

                <tr>
                    <td>Detalle de Hardware asignado</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <div>
                <p>
                    ACUERDO : El equipo descrito en el presente documento se entrega al usuario, cuyos datos y firmas se consignan a continuación, para los fines de cumplir con sus labores de acuerdo con el contrato laboral suscrito con EXPERTIS MASTER SERVICER AND COLLECTIONS S.A.C, Al ser solicitado por el empleador, el usuario deberá devolver el equipo a EXPERTIS MASTER SERVICER AND COLLECTIONS S.A.C., con todos los accesorios y equipamiento con la que fue entregado y en buen estado de funcionamiento, considerando el desgaste natural del uso realizado. Es responsabilidad del Usuario otorgar el debido cuidado , y en caso de uso indebido o negligente (ya sea por mal manejo, manipulación o por utilizar el equipo fuera de las instalaciones de la compañia o domicilo) que genere una avería o pérdidad del equipo, será el Usuario el único responsable del costo de la reparación o reposicion del equipo al 100%.
                </p>
            </div>
            <br>
            <br>
            <br>
            <table>
                <tr>
                    <td></td>
                    <td  style="align-content: center">RECIBI CONFORME</td>
                    <td></td>
                    <td  style="align-content: center">ENTREGADO POR</td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <table>
                <tr>
                    <td></td>
                    <td  style="border-top:solid 1px black"></td>
                    <td></td>
                    <td  style="border-top:solid 1px black"></td>
                </tr>
                <tr>
                    <td></td>
                    <td  style="align-content: center">NOMBRE</td>
                    <td></td>
                    <td  style="align-content: center">NOMBRE</td>
                </tr>
                <tr>
                    <td></td>
                    <td  style="align-content: center">FECHA</td>
                    <td></td>
                    <td  style="align-content: center">FECHA</td>
                </tr>
            </table>
        </main>
    </body>
</html>
