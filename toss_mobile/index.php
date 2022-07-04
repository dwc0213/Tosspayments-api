<?
	session_start();

	include "../../module/class/class.DbCon.php";
	include "../../module/class/class.Util.php";
	include "../../module/class/class.Msg.php";

/*
	LG전자결제 사용자 수정파일
	./index.php
	./payreq.php
	./payres.php
	./lgdacom/conf/mall.conf
*/

	$shop_id = 'ssez2020';	 //상점아이디

	$shop_plat = 'test';	//테스트여부(test:테스트, service:서비스)

	if($pay_mode == '신용카드'){
		$pay_txt = 'SC0010';	//신용카드

	}elseif($pay_mode == '계좌이체'){
		$pay_txt = 'SC0030';	//계좌이체

	}elseif($pay_mode == '무통장입금'){
		$pay_txt = 'SC0040';	//무통장입금

	}


	$reg_date = mktime();
	$lg_name = $oname;
	$userip = $_SERVER[REMOTE_ADDR];

	if(!$userid)	$userid = '_guest';
	$lg_userid = $userid;
	$lg_title = '황후나비';

	$lg_amt = $amt;

	$lg_email = $oemail;




	//결제정보 임시저장
	include 'insert.php';


?>


<form method="post" name='LGD_PAYINFO' id="LGD_PAYINFO" action="payreq_crossplatform.php">
<input type="hidden" name="CST_MID" value="<?=$shop_id?>"/><!--상점아이디(t를 제외한 아이디)-->
<input type="hidden" name="CST_PLATFORM" value="<?=$shop_plat?>"/><!--서비스,테스트-->

<input type='hidden' name='LGD_CUSTOM_FIRSTPAY' value='<?=$pay_txt?>'><!-- LGU 결제수단 -->
<input type="hidden" name="Device" value="<?=$Device?>"/><!-- iOS 확인  -->

<input type="hidden" name="LGD_BUYER" value="<?=$lg_name?>"/><!--구매자 이름-->
<input type="hidden" name="LGD_BUYERIP" value="<?=$userip?>"/><!--구매자IP-->
<input type="hidden" name="LGD_BUYERID" value="<?=$lg_userid?>"/><!--구매자ID-->
<input type="hidden" name="LGD_PRODUCTINFO" value="<?=$lg_title?>"/><!--상품정보-->
<input type="hidden" name="LGD_AMOUNT" value="<?=$lg_amt?>"/><!--결제금액-->
<input type="hidden" name="LGD_BUYEREMAIL" value="<?=$lg_email?>"/><!--구매자 이메일-->
<input type="hidden" name="LGD_OID" value="<?=$reg_date?>"/><!--주문번호-->
</form>


<script language='javascript'>document.LGD_PAYINFO.submit();</script>


