<?php

namespace App\Models\Export;


use Carbon\Carbon;
use PDF;
use URL;
use Storage;

class WorkOrderPDF extends PDF
{

    public static function Header($ticket, $workOrder)
    {


        PDF::SetFont('helvetica', 'BI', 9);

        $week = Carbon::now()->weekOfYear;

        $date = Carbon::now()->format("Y/m/d");
        $time = Carbon::now()->format("H:i:s");

        $logo = public_path()."/img/logo_japam.png";

        // DAtos
        $headerdata = <<<HTML
        
                <table style="width:100%;border:2pt solid black;padding:4px;">
                <tbody>
                
                    <tr>  
                        <td style="width:15%;">
                            <img src="{$logo}"><img>
                        </td>
                        <td style="width:70%; text-align:center;"> 
                            <h1> Orden de Trabajo 2</h1>
                        </td>
                        <td style="width:15%;">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            FOLIO: {$workOrder['folio']}
                                        </td>
                                    </tr>
                                    <tr>
                                         <td>
                                            Semana: {$week}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>   
                </table>               
HTML;
        PDF::writeHTML($headerdata, true, false, true, false, false, 'C');



        $last = count($ticket["appTicket"]);
        $name ="";
        $contract = "";
        $meter = "";
        $description = "";
        $count = 0;
        foreach($ticket["appTicket"] as $i => $appt){

            if($count === $last) {
                if($appt["appUser"] !== null){
                    $name .= $appt["appUser"]["people"]["name"]." ". $appt["appUser"]["people"]["last_name_1"];
                }elseif($appt["peopleUnlogged"] !== null ){
                    $name .= $appt["peopleUnlogged"]["name"];
                }else{
                    $name .= "Anónimo";
                }

                $contract .= $appt["contract"];
                $meter .= $appt["meter"];
                $description .= $appt["description"];
            }else{
                if($appt["appUser"] !== null){
                    $name .= $appt["appUser"]["people"]["name"]." ". $appt["appUser"]["people"]["last_name_1"].",";
                }elseif($appt["peopleUnlogged"] !== null ){
                    $name .= $appt["peopleUnlogged"]["name"].",";
                }else{
                    $name .= "Anónimo ,";
                }
                $contract .= $appt["contract"] . ",";
                $meter .= $appt["meter"]. ",";
                $description .= $appt["description"]. ",";
            }

            $count++;
        }

        $pdfdata =
            '<table style="width:100%; border:2px solid black;">
                <tbody>
                    <tr style="margin:10px">  <!-- Coordinado mesa de control--> 
                        <!--<td style="border:1px solid black; width:10%;">
                            <p style=" writing-mode: tb-rl;">
                            COORDINADO DE MESA DE CONTROL
                            </p>
                        </td>-->
                        <td style="width:100%;">
                            <table><!--Division orden info-->
                                <tbody>
                                    <tr>
                                        <td style="border:1px solid black;">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>Fecha:</td>
                                                        <td>'.$date.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hora:</td>
                                                        <td>'.$time.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sector:</td>
                                                        <td>'. $ticket["suburb"]["sector"]["name"].'-'. $ticket["suburb"]["suburb"].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Código de Equipo:</td>
                                                        <td>'. $workOrder["PMOEquipment"]["description"].'-'.$workOrder["PMOEquipment"]["code"].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td> Depto. Ejecutor</td>
                                                        <td>'.$workOrder["PMOCategory"]["name"].'</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width:50%; border:1px solid black;">
                                            <table>
                                                <tbody>
                                                    <tr style="width:50%; border:1px solid black;">
                                                        <td>Solicita:</td>
                                                        <td><label>'. $workOrder["user"]["name"] .'</label></td>
                                                    </tr>
                                                    <tr style="width:50%; border:1px solid black;">
                                                        <td>Departamento:</td>
                                                        <td>'.$ticket["category"]["name"].'</td>
                                                    </tr>
                                                    <tr style="width:100%; border:1px solid black;">
                                                        <td style="width:100%; border:1px solid black;">Trabajo a ejecutar:</td>
                                                    </tr>
                                                    <tr><td style="width:100%; border:1px solid black;">
                                                        '. $workOrder["PMOWork"]["description"] .'
                                                    </td></tr>
                                                    <tr><td style="width:100%; border:1px solid black;"></td></tr>
                                                    <tr style="width:100%; border:1px solid black;">
                                                        <td>Posible causa:</td>
                                                    </tr>
                                                    <tr><td style="width:100%; border:1px solid black;">
                                                    </td></tr>
                                                    <tr><td style="width:100%; border:1px solid black;"></td></tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;">
                                            <table style=" border:1px solid black;"><!-- Tipo de trabajo-->
                                                <tbody>
                                                    <tr>
                                                        <td style="width:100%; border:1px solid black;">
                                                        Tipo de trabajo
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:100%; height:40px; border:1px solid black;">
                                                            '.$workOrder["PMOWorktype"]["type"].'
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width:70%;">
                                            <table style="width:100%; border:1px solid black;">
                                                <tbody>
                                                    <tr colspan="2" style="border:1px solid black;">
                                                        <td>Datos del Usuario</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width:25%;">
                                                                            Usuario
                                                                        </td>
                                                                        <td style="width:75%; border:1px solid black;">'.$name.'</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:25%;">
                                                                            Domicilio
                                                                        </td>
                                                                        <td style="width:75%; border:1px solid black;"><p>'.$ticket["street"].' '.$ticket["outside_number"].'</p></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:25%;">
                                                                            Colonia
                                                                        </td>
                                                                        <td style="width:75%; border:1px solid black;">'.$ticket["suburb"]["suburb"].'</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:25%;">
                                                                            No. Contrato
                                                                        </td>
                                                                        <td style="width:75%; border:1px solid black;">'. $contract .'</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:25%;">
                                                                            No. Medidor
                                                                        </td>
                                                                        <td style="width:75%; border:1px solid black;">'. $meter .'</td>
                                                                    </tr>
                                                                    <tr rowspan="3">
                                                                        <td style="width:25%;">
                                                                            Observaciones
                                                                        </td>
                                                                        <td style="width:75%; border:1px solid black;">'. $description .'</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="border:1px solid black;">Aceptación y Prioridad</td>
                                                    </tr>
                                                    <tr style"height: 50px;">
                                                        <td style="width:50%; border:1px solid black;">
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><label> Priodidad:</label></td>
                                                                        <td><label>'. $ticket["priority"]["name"] .'</label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label> Vo.Bo.</label></td>
                                                                        <td><label>'. $workOrder["user"]["name"] .'</label></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td style="width:50%; border:1px solid black;">
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><label> Fecha Limite:</label></td>
                                                                        <td><label>'. $workOrder["deadline"] .'</label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label> Ticket</label></td>
                                                                        <td><label>'. $ticket["folio"] .'</label></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table> 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr style="margin:20px">
                        <!--<td style="border:1px solid black; width:10%;">
                            <p style="writing-mode: tb-rl;">
                            COORDINADO DE EJECUTOR
                            </p>
                        </td>-->
                        <td style="width:100%;">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <table style="border:1px solid black;">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            Trabajo Realizado
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="width:100%; border:1px solid black;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="width:100%; border:1px solid black;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="width:100%; border:1px solid black;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="width:100%; border:1px solid black;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="width:100%; border:1px solid black;">
                                                        </td>
                                                    </tr>
                                                    <tr rowspan="4">
                                                        <td>
                                                            <div>
                                                                <label style="font-size: 7px">No de Contrato:</label>
                                                                <label>'. $ticket["app_ticket"]["contract"] .'</label>
                                                            </div>
                                                            <div>
                                                                <label style="font-size: 7px">Realizo:</label>
                                                                <label>'.  $workOrder["user"]["name"] .'</label>
                                                            </div>
                                                            <div>
                                                                <label style="font-size: 7px">Vo.Bo Supervisor:</label>
                                                                <label></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table style="width:100%; solid black;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:70%;">1.- Operación</td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:5%;" border="1"> <input /></td>
                                                        <td style="width:5%;"> <input /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2.- Mala Operación</td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:5%;" border="1"> <input /></td>
                                                        <td style="width:5%;"> <input /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3.- Desgaste Prematuro</td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:5%;" border="1"> <input /></td>
                                                        <td style="width:5%;"> <input /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>4.- Diseño Deficiente</td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:5%;" border="1"> <input /></td>
                                                        <td style="width:5%;"> <input /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>5.- Suciedad</td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:5%;" border="1"> <input /></td>
                                                        <td style="width:5%;"> <input /></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>6.- Reparación defectuosa</td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:5%;" border="1"> <input /></td>
                                                        <td style="width:5%;"> <input /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>7.- Material Defectuoso</td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:5%;" border="1"> <input /></td>
                                                        <td style="width:5%;"> <input /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>8.- Ampliación</td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:5%;" border="1"> <input /></td>
                                                        <td style="width:5%;"> <input /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>9.- Crecimiento</td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:5%;" border="1"> <input /></td>
                                                        <td style="width:5%;"> <input /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>10.- Rep. Obra Civíl</td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:10%;"> <input /></td>
                                                        <td style="width:5%;" border="1"> <input /></td>
                                                        <td style="width:5%;"> <input /></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr style="width:100%;">
                                        <td colspan="2">
                                            <table style="width:100%; border:1px solid black;">
                                                <tr>
                                                    <td>
                                                        <table>
                                                            <thead>
                                                                <tr align="center">
                                                                    <th colspan="3" style="  border:1px solid black;">
                                                                        Materiales
                                                                    </th style="  border:1px solid black;">
                                                                </tr>
                                                                <tr>
                                                                    <th style="  border:1px solid black;">
                                                                        Código
                                                                    </th style="  border:1px solid black;">
                                                                    <th>
                                                                        Descripción
                                                                    </th>
                                                                    <th style="  border:1px solid black;">
                                                                        Cantidad
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table>
                                                            <thead>
                                                                <tr align="center">
                                                                    <th colspan="4" style="  border:1px solid black;">
                                                                        Mano de obra
                                                                    </th style="  border:1px solid black;">
                                                                </tr>
                                                                <tr>
                                                                    <th style="  border:1px solid black;">
                                                                        No. Control
                                                                    </th>
                                                                    <th style="  border:1px solid black;">
                                                                        Escpecialidad
                                                                    </th>
                                                                    <th style="  border:1px solid black;">
                                                                        Hrs Normales
                                                                    </th>
                                                                    <th style="  border:1px solid black;">
                                                                        Hrs. Extras
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                    <td style="  border:1px solid black;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border:1px solid black;"></td>
                                                                    <td style="border:1px solid black;"></td>
                                                                    <td style="border:1px solid black;"></td>
                                                                    <td style="border:1px solid black;"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr> 
                    <tr style="margin:20px">
                        <!--<td style="height: 100px; padding:5px;">
                            <p style="writing-mode:vertical-rl; -ms-writing-mode:tb-rl;">
                                CONTROL
                            </p>
                        </td>-->
                        <td style="width:100%;">
                            <table style="width:100%; border:1px solid black;">
                                <tbody>
                                    <tr>
                                        <td style="width: 40%; border:1px solid black;">
                                           <table style="width:100%;">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        Mano de Obra $
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        Material $
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        Herramientas $
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        Otros $
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        Total $
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width:25%; border:1px solid black;">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" style="font-size: 5px">
                                                        Vo. Bo. JEFE DEPARTAMENTAL EJECUTOR
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        Firma
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        Fecha Histórica:
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width:15%; border:1px solid black;">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" style="font-size: 5px">
                                                        Vo. Bo. SOLICITANTE
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="font-size: 7px">
                                                            Nivel de satisfacción
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:100%;">
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width:10%; border:1px solid black;">
                                                                        </td>
                                                                        <td style="width:10%; border:1px solid black;">
                                                                        </td>
                                                                        <td style="width:10%; border:1px solid black;">
                                                                        </td>
                                                                        <td style="width:10%; border:1px solid black;">
                                                                        </td>
                                                                        <td style="width:10%; border:1px solid black;">
                                                                        </td>
                                                                        <td style="width:10%; border:1px solid black;">
                                                                        </td>
                                                                        <td style="width:10%; border:1px solid black;">
                                                                        </td>
                                                                        <td style="width:10%; border:1px solid black;">
                                                                        </td>
                                                                        <td style="width:10%; border:1px solid black;">
                                                                        </td>
                                                                        <td style="width:10%; border:1px solid black;">
                                                                        </td>
                                                                    </tr>
                                                                </tbod>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:100%; font-size: 7px;">
                                                        Firma
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width:20%; border:1px solid black;">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" style="font-size: 5px">
                                                        Fecha y hora de terminación
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        Fecha
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        Hora
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 7px">
                                                        
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>';

        PDF::writeHTML($pdfdata, true, false, true, false, false, 'C');

    }

    public static function Footer($ticket, $workOrder)
    {
        // Position at 15 mm from bottom
        PDF::SetY(-15);
        // Set font
        PDF::SetFont('helvetica', 'I', 8);
        // Page number
        PDF::Cell(0, 10, 'Página ' . PDF::getAliasNumPage() . '/' . PDF::getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public static function workerOrderPDF($ticket, $orderWork)
    {
        //try {
        //Informacion del documento
        PDF::SetCreator("ISOTECH");
        PDF::SetTitle('ORDEN DE TRABAJO ' . $orderWork["id"]);
        PDF::SetHeaderMargin(PDF_MARGIN_HEADER);

        PDF::setMargins(10, 10, 10);

        PDF::setHeaderCallback(function () use (& $ticket, $orderWork) {

            WorkOrderPDF::Header($ticket, $orderWork);
        });

        PDF::setFooterCallback(function () use (& $ticket, $orderWork) {

            WorkOrderPDF::Footer($ticket, $orderWork);
        });
        if (!is_dir(base_path() . "/storage/app/workOrder")) {
            $path = base_path() . "/storage/app/workOrder";
            \File::makeDirectory($path, $mode = 0777, true, true);

        }


        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::SetFont('helvetica', 'BI', 8);

        if (!is_dir(base_path() . "/storage/app/workOrder/" . $orderWork["ticket_id"] . '/')) {
            $path = base_path() . "/storage/app/workOrder/" . $orderWork["ticket_id"] . '/';
            \File::makeDirectory($path, $mode = 0777, true, true);
        }


        PDF::Output(storage_path("/app/workOrder/". $orderWork["ticket_id"] . '/' . $orderWork["id"] . '.pdf') , 'F');

        return URL::to("../storage/app/workOrder/". $orderWork["ticket_id"] ). '/'. $orderWork["id"] . '.pdf';
        //} catch (Exception $e) {
        //}
    }

}
