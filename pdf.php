<?php 
    require_once 'vendor/autoload.php';
    use Dompdf\Dompdf;

    $dompdf = new Dompdf();
    header('Content-Type: application/pdf');
     $html = '
     <style>
     table {
         border-collapse: collapse;
         width: 100%;
     }
 
     th, td {
         border: 1px solid black;
         padding: 8px;
         text-align: left;
     }
 
     th {
         background-color: #f2f2f2;
     }
 </style>
     <div class="tab-pane fade" id="v-line-pills-released" role="tabpanel" aria-labelledby="v-line-pills-released-tab">
     <table id="zero-config4" class="table dt-table-hover" style="width:100%">
         <thead>
             <tr>
                 <th>Fullname</th>
                 <th>Document</th>
                 <th>Purpose</th>
                 <th>Referece No</th>
                 <th>Payment Method</th>
                 <th>Amount</th>
                 <th>Requested Date</th>
             </tr>
         </thead>
         <tbody>';
             require("connection/db.php");
             $count = 0;
             $totalAmount = 0;
             $query = "
             SELECT 
                 B.ID,
                 A.DateAdded,
                 B.Amount,
                 B.PaymentMethod,
                 A.Purpose,
                 B.ReferenceNo,
                 A.Status,
                 A.ID AS RequestID,
                 A.Reason,
                 B.Status AS PaymentStatus,
                 C.ID AS UserID,
                 C.Firstname,
                 C.Lastname,
                 D.DocumentName,
                 A.ReceiveDate,
                 DATE_FORMAT( STR_TO_DATE(A.ReceiveDate, '%Y-%m-%d' ), '%Y%m%d' ) AS DateNumber,
                 E.Firstname AS ReleasedBy
             FROM request_form A
             LEFT JOIN payment B ON B.RequestFormID = A.ID
             INNER JOIN users C ON C.ID = A.UserID
             INNER JOIN document_list D ON D.ID = A.DocumentID
             LEFT JOIN users E ON E.ID = A.ReleasedBy
             WHERE A.Status = 5
             ORDER BY A.ID ASC";
             if ($result = $mysqli->query($query)) {
                 while($row = $result->fetch_array()){

                     $ReferenceNo = "";
                     

                     if($row['PaymentMethod'] == "GCASH"){
                         $ReferenceNo = "<a class='btn_View_Receipt' ReferenceNo='".$row['ReferenceNo']."' href='#'><u>" . $row['ReferenceNo'] . "</u></a>";
                     }
                     else{
                         $ReferenceNo = $row['ReferenceNo'];
                     }
                     $Button = "";

                     if ($row['Status'] == 0){
                         $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Confirm_Request text-info">Approve</a>&nbsp;&nbsp;';
                         $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Decline text-danger">Decline</a>';
                     }
                     else if($row['Status'] == 1){
                         $Button .= "<span class='badge badge-primary'>For Payment</span>&nbsp;";
                         $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Undo text-primary">Undo</a>';
                     }
                     else if($row['Status'] == 2){
                         $Button = '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Set text-info">Set Appointment</a>';
                     }
                     else if ($row['Status'] == 3){
                         if($row['DateNumber'] > date('Ymd')){
                             $Button .= "<span class='badge badge-primary'>For Releasing</span>&nbsp;&nbsp;";
                             $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Release text-primary">Release</a>&nbsp;&nbsp;';
                             $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Edit text-primary">Edit</a>';
                         }
                         else{
                             $Button .= "<span class='badge badge-warning'>Delayed</span>";
                         }
                     }
                      if ($row['Status'] == 5){
                         $Button .= "<span class='badge badge-info'>Released</span>";
                     }
                     else{
                         $Button = "<span class='badge badge-danger'><a href='#' Reason='".$row['Reason']."' class='btn_Action_View_R'>Declined</a></span>&nbsp;";
                         $Button .= '<a href="#" UserID="'.$row['UserID'].'" RequestID="'.$row['RequestID'].'" RecordID="'.$row['ID'].'" class="btn_Action_Undo text-primary">Undo</a>';
                     }
                     $html .= '<tr>
                     <td>'.$row['Firstname'].' '.$row['Lastname'].'</td>
                     <td>'.$row['DocumentName'].'</td>
                     <td>'.$row['Purpose'].'</td>
                     <td>'.$ReferenceNo.'</td>
                     <td>'.$row['PaymentMethod'].'</td>
                     <td>'.$row['Amount'].'</td>
                     <td>'.$row['DateAdded'].'</td>
                 </tr>';
                 $totalAmount += $row['Amount'];
                 }
                 $html .= '</tbody>
                 <tfoot>
                   <tr>
                     <td colspan="5" style="text-align:right; margin-left:5px">Total Amount:</td>
                     <td>'.$totalAmount.'</td>
                     <td></td>
                   </tr>
                 </tfoot>';
             }
                     
    $html .= '</table> </div>';

    $dompdf->loadHtml($html);
    
    $dompdf->render();

    $dompdf->stream("document.pdf", array("Attachment" => false));
?>