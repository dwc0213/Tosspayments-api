<?
	session_start();

	include "../../module/class/class.DbCon.php";
	include "../../module/class/class.Util.php";
	include "../../module/class/class.Msg.php";

/*
	LG���ڰ��� ����� ��������
	./index.php
	./payreq.php
	./payres.php
	./lgdacom/conf/mall.conf
*/

	$shop_id = 'ssez2020';	 //�������̵�

	$shop_plat = 'test';	//�׽�Ʈ����(test:�׽�Ʈ, service:����)

	if($pay_mode == '�ſ�ī��'){
		$pay_txt = 'SC0010';	//�ſ�ī��

	}elseif($pay_mode == '������ü'){
		$pay_txt = 'SC0030';	//������ü

	}elseif($pay_mode == '�������Ա�'){
		$pay_txt = 'SC0040';	//�������Ա�

	}


	$reg_date = mktime();
	$lg_name = $oname;
	$userip = $_SERVER[REMOTE_ADDR];

	if(!$userid)	$userid = '_guest';
	$lg_userid = $userid;
	$lg_title = 'Ȳ�ĳ���';

	$lg_amt = $amt;

	$lg_email = $oemail;




	//�������� �ӽ�����
	include 'insert.php';


?>


<form method="post" name='LGD_PAYINFO' id="LGD_PAYINFO" action="payreq_crossplatform.php">
<input type="hidden" name="CST_MID" value="<?=$shop_id?>"/><!--�������̵�(t�� ������ ���̵�)-->
<input type="hidden" name="CST_PLATFORM" value="<?=$shop_plat?>"/><!--����,�׽�Ʈ-->

<input type='hidden' name='LGD_CUSTOM_FIRSTPAY' value='<?=$pay_txt?>'><!-- LGU �������� -->
<input type="hidden" name="Device" value="<?=$Device?>"/><!-- iOS Ȯ��  -->

<input type="hidden" name="LGD_BUYER" value="<?=$lg_name?>"/><!--������ �̸�-->
<input type="hidden" name="LGD_BUYERIP" value="<?=$userip?>"/><!--������IP-->
<input type="hidden" name="LGD_BUYERID" value="<?=$lg_userid?>"/><!--������ID-->
<input type="hidden" name="LGD_PRODUCTINFO" value="<?=$lg_title?>"/><!--��ǰ����-->
<input type="hidden" name="LGD_AMOUNT" value="<?=$lg_amt?>"/><!--�����ݾ�-->
<input type="hidden" name="LGD_BUYEREMAIL" value="<?=$lg_email?>"/><!--������ �̸���-->
<input type="hidden" name="LGD_OID" value="<?=$reg_date?>"/><!--�ֹ���ȣ-->
</form>


<script language='javascript'>document.LGD_PAYINFO.submit();</script>


