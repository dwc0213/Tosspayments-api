<?
	//�����ݾ��� �ִ� ���
	if($cPrice){
		$cnt = count($cnumber);

		if($cnt == 0){
			Msg::backMsg('���ٿ���');
			exit;

		}else{
			$cAmt = 0;
			$couponTxt = '';

			for($i=0; $i<$cnt; $i++){
				$coupon = $cnumber[$i];

				if($coupon){
					//���� ��ȿ���˻�
					$cChk = Util::CouponCheck($coupon,$dbconn);

					if($cChk == ''){
						Msg::backMsg('[$coupon] �߸��� ������ȣ�Դϴ�');
						exit;

					}elseif($cChk == 'used'){
						Msg::backMsg('[$coupon] �̹� ���� ������ȣ�Դϴ�');
						exit;

					}elseif($cChk == 'end'){
						Msg::backMsg('[$coupon] ��ȿ�Ⱓ�� ����� ������ȣ�Դϴ�');
						exit;

					}elseif($cChk > 0){
						$cAmt += 1;

						if($couponTxt)	$couponTxt .= ',';
						$couponTxt .= $coupon;
					}
				}
			}

			$cChk = $cAmt * 79000;

			//�������밡
			$amt -= $cChk;
			$lg_amt = $amt;
		}
	}

	$cart_num = explode(',',$cart_idx);
	$clen = count($cart_num);

	$errMsg = "";

	//�ߺ���ǰ ���� ó����
	$invenArr = Array();
	$invenArrEA = Array();

	//���Ȯ��
	for($i=0; $i<$clen; $i++){
		$cid = $cart_num[$i];
		$cea = ${'ea'.$cid};

		$sql = "select * from ks_cart where uid='$cid'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$pid = $row['pid'];
		$pdateTime = $row['pdate'];
		$gdata01 = $row['gdata01'];			//�����Ѻ�������
		$bdata02 = $row['bdata02'];			//���Ѻ�(����)
		$cdata02 = $row['cdata02'];			//���Ѻ�(����)

		//���Ȯ��(����ϱ���)
		$invenID = $pid;					//��ǰUID
		$invenTime = $pdateTime;		//�����
		$invenEA = $cea;					//�ֹ�����

		include '../module/invenChk.php';
	}

	if($errMsg){
		$errMsg .= "\\n��� �����մϴ�";
		Msg::backMsg($errMsg);
		exit;
	}




	$reg_date = mktime();
	$user_ip = $_SERVER['REMOTE_ADDR'];

	if(!$userid)	$userid = '��ȸ��';


	if($ment){
		$ment = eregi_replace("<", "&lt;", $ment);
		$ment = eregi_replace(">", "&gt;", $ment);
		$ment = eregi_replace("\"", "&quot;", $ment);
		$ment = eregi_replace("\|", "&#124;", $ment);
		$ment = eregi_replace("\r\n\r\n", "<P>", $ment);
		$ment = eregi_replace("\r\n", "<BR>", $ment);
	}




	//�ֹ��� ������ �����Ѵ�.
	$sql = "insert into ks_order_tmp (userid,oname,ozip1,ozip2,ozipcode,oaddr1,oaddr2,otel1,otel2,otel3,ohp1,ohp2,ohp3,oemail,pname,pzip1,pzip2,pzipcode,paddr1,paddr2,ptel1,ptel2,ptel3,php1,php2,php3,ment,paymode,account,result_price,ship_price,ship_mode,amt,saleTxt,sale_price,coupon_price,coupon,point,status,ip,reg_date) ";
	$sql .= "values ('$userid','$oname','$ozip1','$ozip2','$ozipcode','$oaddr1','$oaddr2','$otel1','$otel2','$otel3','$ohp1','$ohp2','$ohp3','$oemail','$pname','$pzip1','$pzip2','$pzipcode','$paddr1','$paddr2','$ptel1','$ptel2','$ptel3','$php1','$php2','$php3','$ment','$pay_mode','$ac_name','$result_price','$ship_price','$ship_mode','$amt','$saleTxt','$sale_price','$cChk','$couponTxt','$uPrice','����','$user_ip','$reg_date')";
	$result = mysql_query($sql);





	//�ֹ������� �����Ѵ�.
	$id_list = explode(',',$cart_idx);		//��ٱ���UID
	$tot = count($id_list);

	for($i=0; $i<$tot; $i++){
		$uid = $id_list[$i];

		$sql01 = "select * from ks_cart where uid='$uid'";
		$result01 = mysql_query($sql01);
		$row01 = mysql_fetch_array($result01);

		$pid = $row01['pid'];					//��ǰUID
		$pdate = $row01['pdate'];				//�����
		$pea = ${'ea'.$uid};						//����
		$price01 = ${'p1'.$uid};				//��ǰ����
		$price02 = ${'p2'.$uid};				//�ɼǰ�
		$price03 = ${'op'.$uid} * $pea;		//(��ǰ����+�ɼǰ�) * ����

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

		//�����Ѻ�(�뿩) �ֹ��ɼ�
		$cdata01 = $row01['cdata01'];		//Ű,������
		$cdata02 = $row01['cdata02'];		//������
		$cdata03 = $row01['cdata03'];		//�Ź�
		$cdata04 = $row01['cdata04'];		//����
		$cdata05 = $row01['cdata05'];		//����
		$cdata06 = $row01['cdata06'];		//����
		$cdata07 = $row01['cdata07'];		//Ư�̻���


		//��ǰ����
		$sql02 = "select * from ks_product where uid='$pid'";
		$result02 = mysql_query($sql02);
		$row02 = mysql_fetch_array($result02);

		$pcade01 = $row02['cade01'];
		$pcade02 = $row02['cade02'];
		$ptitle = $row02['title'];



		$sql03 = "insert into ks_order_list_tmp (userid,code,pid,pcade01,pcade02,ptitle,pdate,pea,price01,price02,price03,gdata01,gdata02,gdata03,gdata04,gdata05,gdata06,gdata07,gdata08,gdata09,mdata01,mdata02,mdata03,mdata04,mdata05,bdata01,bdata02,bdata03,bdata04,bdata05,bdata06,bdata07,cdata01,cdata02,cdata03,cdata04,cdata05,cdata06,cdata07,etc01,etc02,etc03,etc04) values ('$userid','$reg_date','$pid','$pcade01','$pcade02','$ptitle','$pdate','$pea','$price01','$price02','$price03','$gdata01','$gdata02','$gdata03','$gdata04','$gdata05','$gdata06','$gdata07','$gdata08','$gdata09','$mdata01','$mdata02','$mdata03','$mdata04','$mdata05','$bdata01','$bdata02','$bdata03','$bdata04','$bdata05','$bdata06','$bdata07','$cdata01','$cdata02','$cdata03','$cdata04','$cdata05','$cdata06','$cdata07','$etc01','$etc02','$etc03','$etc04')";
		$result03 = mysql_query($sql03);
	}
?>