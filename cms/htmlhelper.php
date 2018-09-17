<?
// html helper

require_once('inc.php');

// output html table from a result set. the column name will be the header
function html_datatable($st,$cssclass)
{
    $st->execute();
    $html = "<table class='$cssclass'>";
    $i = 0;
    while($r = $st->fetch(PDO::FETCH_ASSOC)) {
        if($i == 0) {
            $keys = array_keys($r);
            $html .= "<thead><tr>";
            foreach ($keys as $k) {
                $html .= "<th>$k</th>";
            }
            $html .= "</tr></thead><tbody>";
        }

        $html .= "<tr>";
        foreach ($keys as $k) {
            $data = $r[$k];
            $html .= "<td>$data</td>";
        }
        $html .= "</tr>";
        $i++;
    }
    $html .= "</tbody></table>";
    return $html; 
}

function html_select($name,$id,$cssclass,$sql,$valuefield,$textfield)
{
    $pdo = get_pdo();
    $st = $pdo->prepare($sql);
    $st->execute();
    $rs = $st->fetchAll();
    $html = "<select name='$name' id='$id' class='$cssclass'>";
    foreach($rs as $row) {
        $v = htmlspecialchars($row[$valuefield]);
        $t = htmlspecialchars($row[$textfield]);
        $html .= "<option value='$v'>$t</option>";
    }
    $html .= "</select>";
    return $html;
}
?>