<?
	include "../../module/class/class.DbCon.php";
	include "../../module/class/class.Util.php";
	include "../../module/class/class.Msg.php";
// ks_order ���Žð� ������ �ſ�ī��
// ks_order_list ���žȿ� ���ų���, �󼼳���
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

	$pname = $row['pname'];
	$pzip1 = $row['pzip1'];
	$pzip2 = $row['pzip2'];
	$pzipcode = $row['pzipcode'];
	$paddr1 = $row['paddr1'];
	$paddr2 = $row['paddr2'];
	$ptel1 = $row['ptel1'];
	$ptel2 = $row['ptel2'];
	$ptel3 = $row['ptel3'];
	$php1 = $row['php1'];
	$php2 = $row['php2'];
	$php3 = $row['php3'];

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


	if($paymode == '�������Ա�')		$status = '�Աݴ��';
	else										$status = '�����Ϸ�';




	//�����˻�
	if($coupon){
		$cArr = explode(',',$coupon);
		$cnt = count($cArr);
		for($i=0; $i<$cnt; $i++){
			$cTxt = $cArr[$i];

			//���� ��ȿ���˻�
			$cChk = Util::CouponCheck($cTxt,$dbconn);

			if($cChk == 'used'){
				$errMsg = '�̹� ���� ������ȣ�Դϴ�';
				$isDBOK = false;

			}elseif($cChk == 'end'){
				$errMsg = '��ȿ�Ⱓ�� ����� ������ȣ�Դϴ�';
				$isDBOK = false;

			}elseif($cChk == ''){
				$errMsg = '�߸��� ������ȣ�Դϴ�';
				$isDBOK = false;
			}
		}
	}


	//���Ȯ��
	if($isDBOK){
		$errMsg = '';

		$sql01 = "select * from ks_order_list_tmp where userid='$userid' and code='$reg_date' and pid>0 order by uid";
		$result01 = mysql_query($sql01);
		$num01 = mysql_num_rows($result01);

		for($i=0; $i<$num01; $i++){
			$row01 = mysql_fetch_array($result01);

			$pid = $row01['pid'];
			$pdateTime = $row01['pdate'];
			$pea = $row01['pea'];
			$gdata01 = $row01['gdata01'];			//�����Ѻ�������
			$bdata02 = $row01['bdata02'];			//���Ѻ�(����)
			$cdata02 = $row01['cdata02'];			//���Ѻ�(����)

			//���Ȯ��(����ϱ���)
			$invenID = $pid;					//��ǰUID
			$invenTime = $pdateTime;		//�����
			$invenEA = $pea;					//�ֹ�����

			include '../invenChk.php';
		}

		if($errMsg){
			$errMsg .= "\\n��� �����Ͽ� ������ ��ҵǾ����ϴ�";
			$isDBOK = false;
		}
	}



	if($isDBOK){

		//�ֹ��� ������ �����Ѵ�.
		$sql = "insert into ks_order (userid,oname,ozip1,ozip2,ozipcode,oaddr1,oaddr2,otel1,otel2,otel3,ohp1,ohp2,ohp3,oemail,pname,pzip1,pzip2,pzipcode,paddr1,paddr2,ptel1,ptel2,ptel3,php1,php2,php3,ment,paymode,result_price,ship_price,ship_mode,amt,saleTxt,sale_price,coupon_price,coupon,point,status,ip,reg_date) ";
		$sql .= "values ('$userid','$oname','$ozip1','$ozip2','$ozipcode','$oaddr1','$oaddr2','$otel1','$otel2','$otel3','$ohp1','$ohp2','$ohp3','$oemail','$pname','$pzip1','$pzip2','$pzipcode','$paddr1','$paddr2','$ptel1','$ptel2','$ptel3','$php1','$php2','$php3','$ment','$paymode','$result_price','$ship_price','$ship_mode','$amt','$saleTxt','$sale_price','$coupon_price','$coupon','$point','$status','$ip','$reg_date')";

		$result = mysql_query($sql);




		//�������� ����� ���
		if($point > 0){
			//����� ������ ��볻�����
			$pmsg = '['.$reg_date.'] �ֹ����';
			$sql = "insert into ks_point (userid,ptype,point,ment,reg_date) values ('$userid','U','$point','$pmsg','$reg_date')";
			$result = mysql_query($sql);

			//����� ����������
			$sql = "update tb_member set point = point - $point where userid='$userid'";
			$result = mysql_query($sql);
		}




		//�������ó��
		if($coupon){
			$cArr = explode(',',$coupon);
			$cnt = count($cArr);

			for($i=0; $i<$cnt; $i++){
				$coupon = $cArr[$i];
				$cmsg = '['.$reg_date.'] �ֹ����';
				$sql = "update ks_coupon_list set r_date='$reg_date', r_userid='$userid', r_name='$oname', ment='$cmsg' where coupon='$coupon'";
				$result = mysql_query($sql);
			}
		}




/* 20171228 ������ ��������
		//ȸ���� ��� �����ݾ��� 2%����
		if($userid && $userid != '_guest'){
			$addPoint = round($amt * 0.02);

			if($paymode == '�������Ա�')	{
				//����� ������ ��볻�� �ӽõ��
				$pmsg = '['.$reg_date.'] �ֹ�����';
				$sql = "insert into ks_point_tmp (userid,ptype,point,ment,reg_date) values ('$userid','O','$addPoint','$pmsg','$reg_date')";
				$result = mysql_query($sql);

			}else{
				//����� ������ ��볻�����
				$pmsg = '['.$reg_date.'] �ֹ�����';
				$sql = "insert into ks_point (userid,ptype,point,ment,reg_date) values ('$userid','O','$addPoint','$pmsg','$reg_date')";
				$result = mysql_query($sql);

				//����� ������ ����
				$sql = "update tb_member set point = point + $addPoint where userid='$userid'";
				$result = mysql_query($sql);
			}
		}
*/


		//��ũ�����̽���
		$ArrData = Array();

		//�ֹ������� �����Ѵ�.
		$sql01 = "select * from ks_order_list_tmp where userid='$userid' and code='$reg_date' order by uid";
		$result01 = mysql_query($sql01);
		$num01 = mysql_num_rows($result01);

		for($i=0; $i<$num01; $i++){
			$row01 = mysql_fetch_array($result01);

			$pid = $row01['pid'];					//��ǰUID
			$pcade01 = $row01['pcade01'];	//�з�
			$pcade02 = $row01['pcade02'];	//�з�
			$ptitle = $row01['ptitle'];				//��ǰ��
			$pdate = $row01['pdate'];				//�����
			$pea = $row01['pea'];					//����
			$price01 = $row01['price01'];		//��ǰ����
			$price02 = $row01['price02'];		//�ɼǰ�
			$price03 = $row01['price03'];		//(��ǰ����+�ɼǰ�) * ����

			//�����Ѻ�
			$gdata01 = $row01['gdata01'];
			$gdata02 = $row01['gdata02'];
			$gdata03 = $row01['gdata03'];
			$gdata04 = $row01['gdata04'];
			$gdata05 = $row01['gdata05'];
			$gdata06 = $row01['gdata06'];
			$gdata07 = $row01['gdata07'];
			$gdata08 = $row01['gdata08'];
			$gdata09 = $row01['gdata09'];

			//�����Ѻ� > �Կ��Ѻ� �ֹ��ɼ�
			$etc01 = $row01['etc01'];			//�ƾ�
			$etc02 = $row01['etc02'];			//���
			$etc03 = $row01['etc03'];			//����
			$etc04 = $row01['etc04'];			//�븮��

			//�����Ѻ�
			$mdata01 = $row01['mdata01'];
			$mdata02 = $row01['mdata02'];
			$mdata03 = $row01['mdata03'];
			$mdata04 = $row01['mdata04'];
			$mdata05 = $row01['mdata05'];

			//�����Ѻ�(�뿩)
			$bdata01 = $row01['bdata01'];
			$bdata02 = $row01['bdata02'];
			$bdata03 = $row01['bdata03'];
			$bdata04 = $row01['bdata04'];
			$bdata05 = $row01['bdata05'];
			$bdata06 = $row01['bdata06'];
			$bdata07 = $row01['bdata07'];

			//�����Ѻ�(�뿩)
			$cdata01 = $row01['cdata01'];
			$cdata02 = $row01['cdata02'];
			$cdata03 = $row01['cdata03'];
			$cdata04 = $row01['cdata04'];
			$cdata05 = $row01['cdata05'];
			$cdata06 = $row01['cdata06'];
			$cdata07 = $row01['cdata07'];


			$sql02 = "insert into ks_order_list (userid,code,pid,pcade01,pcade02,ptitle,pdate,pea,price01,price02,price03,gdata01,gdata02,gdata03,gdata04,gdata05,gdata06,gdata07,gdata08,gdata09,mdata01,mdata02,mdata03,mdata04,mdata05,bdata01,bdata02,bdata03,bdata04,bdata05,bdata06,bdata07,cdata01,cdata02,cdata03,cdata04,cdata05,cdata06,cdata07,etc01,etc02,etc03,etc04) values ('$userid','$reg_date','$pid','$pcade01','$pcade02','$ptitle','$pdate','$pea','$price01','$price02','$price03','$gdata01','$gdata02','$gdata03','$gdata04','$gdata05','$gdata06','$gdata07','$gdata08','$gdata09','$mdata01','$mdata02','$mdata03','$mdata04','$mdata05','$bdata01','$bdata02','$bdata03','$bdata04','$bdata05','$bdata06','$bdata07','$cdata01','$cdata02','$cdata03','$cdata04','$cdata05','$cdata06','$cdata07','$etc01','$etc02','$etc03','$etc04')";
			$result02 = mysql_query($sql02);


			//��ũ�����̽� ��������
			if($pcade01 == '�����Ѻ�')				$category_code = '001';
			elseif($pcade01 == '�����Ѻ�')			$category_code = '002';
			elseif($pcade01 == 'Ŀ���Ѻ�')			$category_code = '003';
			elseif($pcade01 == '�����Ѻ�')			$category_code = '004';
			elseif($pcade01 == '�����Ѻ�')			$category_code = '005';
			elseif($pcade01 == '��ű�')				$category_code = '006';
			elseif($pcade01 == '�й���(����)')		$category_code = '007';
			elseif($pcade01 == '�����Ѻ�(�Ǹ�)')	$category_code = '008';
			elseif($pcade01 == '�����Ѻ�(�Ǹ�)')	$category_code = '009';
			elseif($pcade01 == '��ű�(�Ǹ�)')		$category_code = '010';
			else												$category_code = '000';

			$ArrData[$i]['product_id'] = $pid;
			$ArrData[$i]['product_name'] = iconv('euc-kr','utf-8',$ptitle);
			$ArrData[$i]['category_code'] = $category_code;
			$ArrData[$i]['category_name'] = iconv('euc-kr','utf-8',$pcade01);
			$ArrData[$i]['quantity'] = $pea;
			$ArrData[$i]['product_final_price'] = $price03;
		}


		//�ӽ����� ���̺��� �����Ѵ�
		$sql = "delete from ks_order_tmp where userid='$userid' and reg_date='$reg_date'";
	//	$result = mysql_query($sql);

		$sql = "delete from ks_order_list_tmp where userid='$userid' and code='$reg_date'";
	//	$result = mysql_query($sql);




		//��ũ�����̽�
		if(isset($_COOKIE["LPINFO"])){
			include 'linkprice.request.php';
		}



		//��������Ȯ��������
		$sql = "select * from ks_order where reg_date='$reg_date' order by uid desc limit 1";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);

		$uid = $row['uid'];




		//���ڹ߼�
		mysql_close($dbconn);
		unset($db);
		unset($dbconn);

		$SMS_ADMIN = 'leehyunjoo';
		$SMS_TYPE = 'order';

		//sms �����ͺ��̽� ����
		include '../../module/class/class.DbConSmsHub.php';
		include '../../module/SmsHub.php';
?>

<form name='frm_lgu' method='post' action='/orderlist/sub01.php'>
<input type='hidden' name='type' value='view'>
<input type='hidden' name='uid' value='<?=$uid?>'>
<input type='hidden' name='lgpay' value='<?=$result_price?>'>
</form>


<script language='javascript'>
alert('������ �Ϸ�Ǿ����ϴ�.');
document.frm_lgu.submit();
</script>




<?
	}
?>