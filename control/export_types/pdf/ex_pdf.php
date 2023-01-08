<?php

 include("mpdf60/mpdf.php");

 $html = "
     <fieldset>
     <h1>Dados Financeiro </h1>

     <p style='font-family:arial;' >Abaixo lista das movimentações financeira</p>
     <p  style='font-family:arial;' >Da data  <b>$data1</b> até a data de <b>$data2</b></p>
      <hr>

      <div class='center' >
      <table class='blueTable'>
        <thead>
          <tr>
            <th>ID</th>
            <th>TIPO</th>
            <th>DATA</th>
            <th>VALOR</th>
            <th>NOTA</th>
          </tr>
        </thead>
          <tbody>";



            foreach ($dados_exp as $key => $value) {

              $tipo = $value->tipo == 1 ? "<span class='tipo_1' >Entrada</span>" : "<span class='tipo_2' >Saida</span>";

              $html .= '<tr>';
              $html .= '<td>'.$value->id.'</td>';
              $html .= '<td>'.$tipo.'</td>';
              $html .= '<td>'.$value->data.' / '.$value->hora.'</td>';
              $html .= '<td>R$ '.$value->valor.'</td>';
              $html .= '<td class="td_nota" >'.$value->nota.'</td>';
              $html .= '</tr>';


            }

            $html  .= "</tbody>
              </table>
              </div>
             </fieldset>
           <hr>
           <div class='copy' >
             <p>PDF By GESTOR LITE - ".date('Y')." | Ferramenta de Script Mundo &copy; </p>
           </div>";

           $css = "

        .td_nota{
          font-size:12px;
        }
        .tipo_1{
          color: #0d9e22;
        }
        .tipo_2{
          color: #b70b0b;
        }
       fieldset{
         font-famiy:arial;
         border: 5px solid #ccc;
         padding:20px;
       }

       h1{
         font-family:arial;
       }

      .copy p{
        font-size:10px;font-family:arial;color:#666;
      }


      fieldset p{
         font-famiy:arial;
       }

       .blueTable thead tr th{
         font-family:arial;
         padding:5px;
       }
       .blueTable tbody tr th{
         font-family:arial;
       }
       .center {
         width: 90%;
         margin: 0 auto;
       }
       table.blueTable {
         border: 1px solid #9962DC;
         background-color: #EEEEEE;
         width: 100%;
         text-align: left;
         border-collapse: collapse;
       }
       table.blueTable td, table.blueTable th {
         border: 1px solid #AAAAAA;
         padding: 2px 1px;
       }
       table.blueTable tbody td {
         font-size: 15px;
         color: #333333;
         font-family:arial;
       }
       table.blueTable tr:nth-child(even) {
         background: #E2D5F5;
       }
       table.blueTable thead {
         background: #B16DE9;
         border-bottom: 1px solid #444444;
       }
       table.blueTable thead th {
         font-size: 17px;
         font-weight: bold;
         color: #181818;
         border-left: 1px solid #0B0C0D;
       }
       table.blueTable thead th:first-child {
         border-left: none;
       }

       table.blueTable tfoot td {
         font-size: 14px;
       }
       table.blueTable tfoot .links {
         text-align: right;
       }
       table.blueTable tfoot .links a{
         display: inline-block;
         background: #1C6EA4;
         color: #FFFFFF;
         padding: 2px 8px;
         border-radius: 5px;
       }
       ";

       $mpdf = new mPDF();
       $mpdf->SetDisplayMode('fullpage');
       $mpdf->WriteHTML($css,1);
       $mpdf->WriteHTML($html);
       $mpdf->Output('financeiro_gestor_lite.pdf');

       header("Content-type:application/pdf");
       header("Content-Disposition:attachment;filename=financeiro_gestor_lite.pdf");
       readfile("financeiro_gestor_lite.pdf");

        if(is_file("financeiro_gestor_lite.pdf")){
          unlink("financeiro_gestor_lite.pdf");
        }

      exit;

?>
