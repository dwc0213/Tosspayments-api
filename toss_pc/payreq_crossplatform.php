<?php

//session_start();
	//if(!$userid)	$userid = '_guest';
	//$lg_userid = $userid;
    /*
     * [���� ������û ������(STEP2-1)]
     *
     * ���������������� �⺻ �Ķ���͸� ���õǾ� ������, ������ �ʿ��Ͻ� �Ķ���ʹ� �����޴����� �����Ͻþ� �߰� �Ͻñ� �ٶ��ϴ�.     
     */

    /*
     * 1. �⺻���� ������û ���� ����
     * 
     * �⺻������ �����Ͽ� �ֽñ� �ٶ��ϴ�.(�Ķ���� ���޽� POST�� ����ϼ���)
     */

	$CST_MID	= 'ssez2020';                             //�������̵�(�佺���̸������� ���� �߱޹����� �������̵� �Է��ϼ���)
	$CST_PLATFORM = 'service';                        //�佺���̸��� ���� ���� ����(test:�׽�Ʈ, service:����)
	$LGD_BUYER = $_POST['oname'];                           //�����ڸ�
	$LGD_PRODUCTINFO  = 'Ȳ�ĳ���';                    //��ǰ�� 																				
																					//�׽�Ʈ ���̵�� 't'�� �ݵ�� �����ϰ� �Է��ϼ���.
	$LGD_AMOUNT		= $_POST['amt'];                          //�����ݾ�("," �� ������ �����ݾ��� �Է��ϼ���)
	$LGD_BUYEREMAIL		= $_POST['oemail'];                      //������ �̸���
	$LGD_OID					= mktime();                             //�ֹ���ȣ(�������� ����ũ�� �ֹ���ȣ�� �Է��ϼ���)
	$LGD_TIMESTAMP = date('YmsHis');
	if($pay_mode == '�ſ�ī��')			$LGD_CUSTOM_USABLEPAY = 'SC0010'; //����Ʈ �������� (�ش� �ʵ带 ������ ������ �������� ���� UI �� ����˴ϴ�.)
	elseif($pay_mode == '������ü')		$LGD_CUSTOM_USABLEPAY = 'SC0030';
	elseif($pay_mode == '�������Ա�') $LGD_CUSTOM_USABLEPAY = 'SC0040';
	$LGD_WINDOW_TYPE = 'iframe';								  //����â ȣ���� (�����Ұ�)
	$LGD_CUSTOM_SWITCHINGTYPE   = 'IFRAME';          //�ſ�ī�� ī��� ���� ������ ���� ��� (�����Ұ�)
	$LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;   //�������̵�(�ڵ�����)	      	
	$LGD_OSTYPE_CHECK		= "P"; //�� P: XPay ����(PC ���� ���): PC��� ����Ͽ� ����� �Ķ���� �� ���μ����� �ٸ��Ƿ� PC���� PC ������������ ���� �ʿ�.	//"P", "M" ���� ����(Null, "" ����)�� ����� �Ǵ� PC ���θ� üũ���� ����
	$LGD_CUSTOM_SKIN	= "red";	//�������� ����â ��Ų
	$LGD_WINDOW_VER		        = "2.5";										//����â ��������
	$LGD_CUSTOM_PROCESSTYPE     = "TWOTR"; 							//�����Ұ�

	$LGD_BUYERID					=$_POST['LGD_BUYERID'];       //������ ���̵�
	$LGD_BUYERIP					= $_POST["LGD_BUYERIP"];       //������IP
	
	//$LGD_ACTIVEXYN			= "N";								//������ü ������ ���, ActiveX ��� ���η� "N" �̿��� ��: ActiveX ȯ�濡�� ������ü ���� ����(IE)

	/*
     * �������(������) ���� ������ �Ͻô� ��� �Ʒ� LGD_CASNOTEURL �� �����Ͽ� �ֽñ� �ٶ��ϴ�. 
     */ 
	 
    $LGD_CASNOTEURL				= "https://".$_SERVER['HTTP_HOST']."/module/toss_pc/cas_noteurl.php";    

    /*
     * LGD_RETURNURL �� �����Ͽ� �ֽñ� �ٶ��ϴ�. �ݵ�� ���� �������� ������ ����Ʈ�� ��  ȣ��Ʈ�̾�� �մϴ�. �Ʒ� �κ��� �ݵ�� �����Ͻʽÿ�.
     */    
    $LGD_RETURNURL				= "https://".$_SERVER['HTTP_HOST']."/module/toss_pc/returnurl.php";

    $configPath                 = "/home/leehyunjoo/www/module/toss_pc/lgdacom";	//�佺���̸������� ������ ȯ������("/conf/lgdacom.conf") ��ġ ����.     

    /*
     *************************************************
     * 2. MD5 �ؽ���ȣȭ (�������� ������) - BEGIN
     * 
     * MD5 �ؽ���ȣȭ�� �ŷ� �������� �������� ����Դϴ�. 
     *************************************************
     */

    require_once("/home/leehyunjoo/www/module/toss_pc/lgdacom/XPayClient.php");
    $xpay = new XPayClient($configPath, $CST_PLATFORM);
   	$xpay->Init_TX($LGD_MID);
	$LGD_TIMESTAMP = $xpay->GetTimeStamp(); 
    $LGD_HASHDATA = $xpay->GetHashData($LGD_MID,$LGD_OID,$LGD_AMOUNT,$LGD_TIMESTAMP);
	
	//�������� �ӽ����� insert.php�� �佺 ȭ���� ������ �ٷ� insert.php�� tmp DB�� �߰��ȴ�
	include 'insert.php';

    /*
     *************************************************
     * 2. MD5 �ؽ���ȣȭ (�������� ������) - END
     *************************************************
     */

    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>�佺���̸��� eCredit���� �����׽�Ʈ</title>
<!-- test 
<script language="javascript" src="https://pretest.tosspayments.com:9443/xpay/js/xpay_crossplatform.js" type="text/javascript"></script>
-->
<!--  service   -->
<script language="javascript" src="https://xpayvvip.tosspayments.com/xpay/js/xpay_crossplatform.js" type="text/javascript"></script>


<script type="text/javascript">

/*
* �����Ұ�.
*/

	var LGD_window_type = '<?= $LGD_WINDOW_TYPE ?>';
	
/*
* �����Ұ�
*/
function launchCrossPlatform(){
	lgdwin = openXpay(document.getElementById('LGD_PAYINFO'), '<?= $CST_PLATFORM ?>', LGD_window_type, null, "", "");
}
/*
* FORM ��  ���� ����
*/
function getFormObject() {
        return document.getElementById("LGD_PAYINFO");
}

/*
 * ������� ó��
 */
function payment_return() {

	var fDoc;
	
		fDoc = lgdwin.contentWindow || lgdwin.contentDocument;
	
		
	if (fDoc.document.getElementById('LGD_RESPCODE').value == "0000") {
		
			document.getElementById("LGD_PAYKEY").value = fDoc.document.getElementById('LGD_PAYKEY').value;
			document.getElementById("LGD_PAYINFO").target = "_self";
			document.getElementById("LGD_PAYINFO").action = "/module/toss_pc/payres.php";
			document.getElementById("LGD_PAYINFO").submit();
	} else {
		alert("LGD_RESPCODE (����ڵ�) : " + fDoc.document.getElementById('LGD_RESPCODE').value + "\n" + "LGD_RESPMSG (����޽���): " + fDoc.document.getElementById('LGD_RESPMSG').value);
		closeIframe();
	}
}

</script>
</head>
<body onload='launchCrossPlatform();'>
<form method="post" name="LGD_PAYINFO" id="LGD_PAYINFO" action="payres.php">
<input type='hidden' name='userid' value='<?=$userid?>'>
<table style='display:none;'>
    <tr>
        <td>������ �̸� </td>
        <td><?= $LGD_BUYER ?></td>
    </tr>
    <tr>
        <td>��ǰ���� </td>
        <td><?= $LGD_PRODUCTINFO ?></td>
    </tr>
    <tr>
        <td>�����ݾ� </td>
        <td><?= $LGD_AMOUNT ?></td>
    </tr>
    <tr>
        <td>������ �̸��� </td>
        <td><?= $LGD_BUYEREMAIL ?></td>
    </tr>
    <tr>
        <td>�ֹ���ȣ </td>
        <td><?= $LGD_OID ?></td>
    </tr>
    <tr>
        <td colspan="2">* �߰� �� ������û �Ķ���ʹ� �޴����� �����Ͻñ� �ٶ��ϴ�.</td>
    </tr>
    <tr>
        <td colspan="2"></td>
    </tr>    
    <tr>
        <td colspan="2">
		<input type="button" value="������û" onclick="launchCrossPlatform();"/>         
        </td>
    </tr>    
</table>

<input type="hidden" id="CST_PLATFORM"				name="CST_PLATFORM"				value="<?=$CST_PLATFORM ?>"/>
<input type="hidden" id="CST_MID"					name="CST_MID"					value="<?=$CST_MID ?>"/>
<input type="hidden" id="LGD_WINDOW_TYPE"			name="LGD_WINDOW_TYPE"			value="<?=$LGD_WINDOW_TYPE ?>"/>
<input type="hidden" id="LGD_MID"					name="LGD_MID"					value="<?=$LGD_MID ?>"/>
<input type="hidden" id="LGD_OID"					name="LGD_OID"					value="<?=$LGD_OID ?>"/>
<input type="hidden" id="LGD_BUYER"					name="LGD_BUYER"				value="<?=$LGD_BUYER ?>"/>
<input type="hidden" id="LGD_PRODUCTINFO"			name="LGD_PRODUCTINFO"			value="<?=$LGD_PRODUCTINFO ?>"/>
<input type="hidden" id="LGD_AMOUNT"				name="LGD_AMOUNT"				value="<?=$LGD_AMOUNT ?>"/>
<input type="hidden" id="LGD_BUYEREMAIL"			name="LGD_BUYEREMAIL"			value="<?=$LGD_BUYEREMAIL ?>"/>
<input type="hidden" id="LGD_CUSTOM_SKIN"			name="LGD_CUSTOM_SKIN"			value="<?=$LGD_CUSTOM_SKIN ?>"/>
<input type="hidden" id="LGD_CUSTOM_PROCESSTYPE"	name="LGD_CUSTOM_PROCESSTYPE"	value="<?=$LGD_CUSTOM_PROCESSTYPE ?>"/>
<input type="hidden" id="LGD_TIMESTAMP"				name="LGD_TIMESTAMP"			value="<?=$LGD_TIMESTAMP ?>"/>
<input type="hidden" id="LGD_HASHDATA"				name="LGD_HASHDATA"				value="<?=$LGD_HASHDATA ?>"/>
<input type="hidden" id="LGD_RETURNURL"				name="LGD_RETURNURL"			value="<?=$LGD_RETURNURL ?>"/>
<input type="hidden" id="LGD_CUSTOM_USABLEPAY"		name="LGD_CUSTOM_USABLEPAY"		value="<?=$LGD_CUSTOM_USABLEPAY ?>"/>
<input type="hidden" id="LGD_CUSTOM_SWITCHINGTYPE"	name="LGD_CUSTOM_SWITCHINGTYPE" value="<?=$LGD_CUSTOM_SWITCHINGTYPE ?>"/>
<input type="hidden" id="LGD_WINDOW_VER"			name="LGD_WINDOW_VER"			value="<?=$LGD_WINDOW_VER ?>"/>
<input type="hidden" id="LGD_OSTYPE_CHECK"			name="LGD_OSTYPE_CHECK"			value="<?=$LGD_OSTYPE_CHECK ?>"/>
<input type="hidden" id="LGD_VERSION"			name="PHP_Non-ActiveX_Standard"			value="PHP_Non-ActiveX_Standard"/>

<!--
������û�� ��LGD_RETURN_MERT_CUSTOM_PARAM�� = ��Y���� ��� ��������� ���� retunurl �� �״�� ����
*���ǻ���
��������� �Ķ���ʹ� LGD_ �� ���۵� �� ����.

<input type="hidden" id="LGD_RETURN_MERT_CUSTOM_PARAM"	name="LGD_RETURN_MERT_CUSTOM_PARAM"	value="Y�� />
<input type="hidden" id="CUSTOM_PARAMETER1"	name="CUSTOM_PARAMETER1"	value="�������� �Ķ���� �� 1���Դϴ�" />
<input type="hidden" id="CUSTOM_PARAMETER2"	name="CUSTOM_PARAMETER2"	value="�������� �Ķ���� �� 2���Դϴ١� />
-->
<!-- 
<input type="hidden" id="LGD_ACTIVEXYN"				name="LGD_ACTIVEXYN"			value="<?=$LGD_ACTIVEXYN ?>"/>
-->
<input type="hidden" id="LGD_VERSION"				name="LGD_VERSION"				value="PHP_Non-ActiveX_Standard"/>
<input type="hidden" id="LGD_DOMAIN_URL"			name="LGD_DOMAIN_URL"			value="xpayvvip"/>
<input type="hidden" id="LGD_CASNOTEURL"			name="LGD_CASNOTEURL"			value="<?=$LGD_CASNOTEURL ?>"/>
<input type="hidden" id="LGD_RESPCODE"				name="LGD_RESPCODE"				value=""/>
<input type="hidden" id="LGD_RESPMSG"				name="LGD_RESPMSG"				value=""/>
<input type="hidden" id="LGD_PAYKEY"				name="LGD_PAYKEY"				value=""/>

</form>
</body>
</html>


