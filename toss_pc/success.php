<?
	include "../../module/class/class.DbCon.php";
	include "../../module/class/class.Util.php";
	include "../../module/class/class.Msg.php";

	$sql = "select * from ks_order_tmp where reg_date='$reg_date' order by uid desc limit 1";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	
	$userid = $row['userid'];
	$oname = $row['oname'];
	$ozip1 = $row['ozip1'];
	$ozip2 = $row['ozip2'];
	$ozipcode = $row['ozipcode'];
	$oaddr1 = $row['oaddr1'];
	$oaddr2 = $row['oaddr2'];
	$otel1 = $row['otel1'];
	$otel2 = $row['otel2'];
	$otel3 = $row['otel3'];
	$ohp1 = $row['ohp1'];
	$ohp2 = $row['ohp2'];
	$ohp3 = $row['ohp3'];
	$oemail = $row['oemail'];

	$ment = $row['ment'];
	$paymode = $row['paymode'];
	$result_price = $row['result_price'];
	$ship_price = $row['ship_price'];
	$ship_mode = $row['ship_mode'];
	$amt = $row['amt'];
	$saleTxt = $row['saleTxt'];
	$sale_price = $row['sale_price'];
	$coupon_price = $row['coupon_price'];
	$coupon = $row['coupon'];
	$point = $row['point'];
	$status = $row['status'];
	$ip = $row['ip'];


	if($paymode == '무통장입금')		$status = '입금대기';
	else										$status = '결제완료';


	

	if($isDBOK){

		//주문자 정보를 저장.
		$sql = "insert into ks_order (userid,oname,ozip1,ozip2,ozipcode,oaddr1,oaddr2,otel1,otel2,otel3,ohp1,ohp2,ohp3,oemail,pname,pzip1,pzip2,pzipcode,paddr1,paddr2,ptel1,ptel2,ptel3,php1,php2,php3,ment,paymode,result_price,ship_price,ship_mode,amt,saleTxt,sale_price,coupon_price,coupon,point,status,ip,reg_date) ";
		$sql .= "values ('$userid','$oname','$ozip1','$ozip2','$ozipcode','$oaddr1','$oaddr2','$otel1','$otel2','$otel3','$ohp1','$ohp2','$ohp3','$oemail','$pname','$pzip1','$pzip2','$pzipcode','$paddr1','$paddr2','$ptel1','$ptel2','$ptel3','$php1','$php2','$php3','$ment','$paymode','$result_price','$ship_price','$ship_mode','$amt','$saleTxt','$sale_price','$coupon_price','$coupon','$point','$status','$ip','$reg_date')";

		$result = mysql_query($sql);

		//결제내역확인페이지
		$sql = "select * from ks_order where reg_date='$reg_date' order by uid desc limit 1";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);

		$uid = $row['uid'];

		//sms 데이터베이스 접속
		include '../../module/class/class.DbConSmsHub.php';
		include '../../module/SmsHub.php';
?>

<form name='frm_lgu' method='post' action='/orderlist/sub01.php'>
<input type='hidden' name='type' value='view'>
<input type='hidden' name='uid' value='<?=$uid?>'>
<input type='hidden' name='lgpay' value='<?=$result_price?>'>
</form>


<script language='javascript'>
alert('결제가 완료되었습니다.');
document.frm_lgu.submit();
</script>

<?
	}
?>
