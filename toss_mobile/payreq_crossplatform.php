<?php

	session_start();

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

	$CST_MID                    = 'ssez2020';					//�������̵�(�佺���̸������� ���� �߱޹����� �������̵� �Է��ϼ���)
    $CST_PLATFORM               = 'service';				//�佺���̸��� ���� ���� ����(test:�׽�Ʈ, service:����)
                                                                        //�׽�Ʈ ���̵�� 't'�� �ݵ�� �����ϰ� �Է��ϼ���.
	$LGD_BUYER                  = $_POST['oname'];	//�����ڸ�
	$LGD_PRODUCTINFO            = 'Ȳ�ĳ���';			//��ǰ��
	$LGD_AMOUNT                 = $_POST['amt'];					//�����ݾ�("," �� ������ �����ݾ��� �Է��ϼ���)
	$LGD_BUYEREMAIL             = $_POST['oemail'];				//������ �̸���
	$LGD_OID                    = mktime();			//�ֹ���ȣ(�������� ����ũ�� �ֹ���ȣ�� �Է��ϼ���)
	$LGD_TIMESTAMP			= date('YmsHis');
	if($pay_mode == '�ſ�ī��')			$LGD_CUSTOM_FIRSTPAY = 'SC0010'; //����Ʈ �������� (�ش� �ʵ带 ������ ������ �������� ���� UI �� ����˴ϴ�.)
	elseif($pay_mode == '������ü')		$LGD_CUSTOM_FIRSTPAY = 'SC0030';
	elseif($pay_mode == '�������Ա�')	$LGD_CUSTOM_FIRSTPAY = 'SC0040';
	$LGD_PCVIEWYN	= $_POST["LGD_PCVIEWYN"];//�޴�����ȣ �Է� ȭ�� ��� ����(����Ĩ�� ���� �ܸ��� �Է�-->����Ĩ�� �ִ� �޴������� ���� ����)
	$LGD_CUSTOM_SKIN            = "SMART_XPAY2";    //�������� ����â ��Ų
	$LGD_CUSTOM_PROCESSTYPE     = "TWOTR";                                       //�����Ұ�
	$LGD_OSTYPE_CHECK           = "M";
    $LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;  //�������̵�(�ڵ�����)
	$LGD_MERTKEY						=	"93200ff88799726d42cee4e94b4a4589";
    $LGD_BUYERID					= $_POST['LGD_BUYERID'];		//������ ���̵�


    /*
     * �������(������) ���� ������ �Ͻô� ��� �Ʒ� LGD_CASNOTEURL �� �����Ͽ� �ֽñ� �ٶ��ϴ�. 
     */
	 
    $LGD_CASNOTEURL				= "https://".$_SERVER['HTTP_HOST']."/module/toss_mobile/cas_noteurl.php";    

    /*
     * LGD_RETURNURL �� �����Ͽ� �ֽñ� �ٶ��ϴ�. �ݵ�� ���� �������� ������ ����Ʈ�� ��  ȣ��Ʈ�̾�� �մϴ�. �Ʒ� �κ��� �ݵ�� �����Ͻʽÿ�.
     */
	 
    $LGD_RETURNURL				= "https://".$_SERVER['HTTP_HOST']."/module/toss_mobile/returnurl.php";  

	$configPath 	= "/home/leehyunjoo/www/module/toss_mobile/lgdacom"; 	//�佺���̸������� ������ ȯ������("/conf/lgdacom.conf") ��ġ ����.
	
	/*
	* ISP ī����� ������ ���� �Ķ����(�ʼ�)
	*/

	$LGD_KVPMISPWAPURL		= "";
	$LGD_KVPMISPCANCELURL   = "";
	
	$LGD_MPILOTTEAPPCARDWAPURL = ""; //iOS ������ �ʼ�
	
	/*
	* ������ü ������ ���� �Ķ����(�ʼ�)
	*/

	$LGD_MTRANSFERWAPURL 		= "";
	$LGD_MTRANSFERCANCELURL 	= "";   
	   
    
    /*
     *************************************************
     * 2. MD5 �ؽ���ȣȭ (�������� ������) - BEGIN
     * 
     * MD5 �ؽ���ȣȭ�� �ŷ� �������� �������� ����Դϴ�. 
     *************************************************
     */

    require_once("/home/leehyunjoo/www/module/toss_mobile/lgdacom/XPayClient.php");
    $xpay = new XPayClient($configPath, $CST_PLATFORM);
   	$xpay->Init_TX($LGD_MID);
	$LGD_TIMESTAMP = $xpay->GetTimeStamp(); 
    $LGD_HASHDATA = $xpay->GetHashData($LGD_MID,$LGD_OID,$LGD_AMOUNT,$LGD_TIMESTAMP);

	include 'insert.php';

    /*
     *************************************************
     * 2. MD5 �ؽ���ȣȭ (�������� ������) - END
     *************************************************
     */
    $CST_WINDOW_TYPE = "submit";							// �����Ұ�
    $LGD_CUSTOM_SWITCHINGTYPE = "SUBMIT";					// �ſ�ī�� ī��� ���� ������ ���� ���

		
	/*
	****************************************************
	* ����� OS�� ISP(����/��), ������ü ���� ���� ��
	****************************************************
	- �ȵ���̵�: A (����Ʈ)
	- iOS: N
	- iOS�� ���, �ݵ�� N���� ���� ����
	*/
	$LGD_KVPMISPAUTOAPPYN	= "A";		// �ſ�ī�� ���� 
	$LGD_MTRANSFERAUTOAPPYN = "A";		// ������ü ����

    
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

<title>�佺���̸��� eCredit���� �����׽�Ʈ</title>
<!-- test 
<script language="javascript" src="https://pretest.tosspayments.com:9443/xpay/js/xpay_crossplatform.js" type="text/javascript"></script>
-->
  
<!-- service --> 
<script language="javascript" src="https://xpayvvip.tosspayments.com/xpay/js/xpay_crossplatform.js" type="text/javascript"></script>


<script type="text/javascript">


	var LGD_window_type = '<?= $CST_WINDOW_TYPE ?>'; 

/*
* �����Ұ�
*/

function launchCrossPlatform(){
      lgdwin = open_paymentwindow(document.getElementById('LGD_PAYINFO'), '<?= $CST_PLATFORM ?>', LGD_window_type);
}

/*
* FORM ��  ���� ����
*/

function getFormObject() {
        return document.getElementById("LGD_PAYINFO");
}

</script>
</head>
<body onload ='launchCrossPlatform();'>
<form method="post" name="LGD_PAYINFO" id="LGD_PAYINFO" action="payres.php">
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

<input type="hidden" id="CST_PLATFORM"				name="CST_PLATFORM"					value="<?=$CST_PLATFORM ?>"/>
<input type="hidden" id="CST_MID"					name="CST_MID"						value="<?=$CST_MID ?>"/>
<input type="hidden" id="LGD_MID"                   name="LGD_MID"                      value="<?=$LGD_MID ?>"/>
<input type="hidden" id="LGD_WINDOW_TYPE"			name="LGD_WINDOW_TYPE"				value="<?=$CST_WINDOW_TYPE ?>"/>
<input type="hidden" id="CST_WINDOW_TYPE"           name="CST_WINDOW_TYPE"              value="<?=$CST_WINDOW_TYPE ?>"/>
<input type="hidden" id="LGD_OID"					name="LGD_OID"						value="<?=$LGD_OID ?>"/>
<input type="hidden" id="LGD_BUYER"					name="LGD_BUYER"					value="<?=$LGD_BUYER ?>"/>
<input type="hidden" id="LGD_PRODUCTINFO"			name="LGD_PRODUCTINFO"				value="<?=$LGD_PRODUCTINFO ?>"/>
<input type="hidden" id="LGD_AMOUNT"				name="LGD_AMOUNT"					value="<?=$LGD_AMOUNT ?>"/>
<input type="hidden" id="LGD_BUYEREMAIL"			name="LGD_BUYEREMAIL"				value="<?=$LGD_BUYEREMAIL ?>"/>
<input type="hidden" id="LGD_CUSTOM_SKIN"			name="LGD_CUSTOM_SKIN"				value="<?=$LGD_CUSTOM_SKIN ?>"/>
<input type="hidden" id="LGD_CUSTOM_PROCESSTYPE"	name="LGD_CUSTOM_PROCESSTYPE"		value="<?=$LGD_CUSTOM_PROCESSTYPE ?>"/>
<input type="hidden" id="LGD_TIMESTAMP"				name="LGD_TIMESTAMP"				value="<?=$LGD_TIMESTAMP ?>"/>
<input type="hidden" id="LGD_HASHDATA"				name="LGD_HASHDATA"					value="<?=$LGD_HASHDATA ?>"/>
<input type="hidden" id="LGD_RETURNURL"				name="LGD_RETURNURL"				value="<?=$LGD_RETURNURL ?>"/>
<input type="hidden" id="LGD_CUSTOM_FIRSTPAY"		name="LGD_CUSTOM_FIRSTPAY"			value="<?=$LGD_CUSTOM_FIRSTPAY ?>"/>
<input type="hidden" id="LGD_CUSTOM_SWITCHINGTYPE"	name="LGD_CUSTOM_SWITCHINGTYPE"		value="<?=$LGD_CUSTOM_SWITCHINGTYPE ?>"/>
<input type="hidden" id="LGD_WINDOW_VER"			name="LGD_WINDOW_VER"				value="<?=$LGD_WINDOW_VER ?>"/>
<input type="hidden" id="LGD_OSTYPE_CHECK"			name="LGD_OSTYPE_CHECK"				value="<?=$LGD_OSTYPE_CHECK ?>"/>
<input type="hidden" id="LGD_VERSION"				name="LGD_VERSION"					value="PHP_Non-ActiveX_Standard"/>
<input type="hidden" id="LGD_DOMAIN_URL"			name="LGD_DOMAIN_URL"				value="xpayvvip"/>
<input type="hidden" id="LGD_CASNOTEURL"			name="LGD_CASNOTEURL"				value="<?=$LGD_CASNOTEURL ?>"/>
<input type="hidden" id="LGD_PCVIEWYN"				name="LGD_PCVIEWYN"					value="<?=$LGD_PCVIEWYN ?>"/>
<input type="hidden" id="LGD_MPILOTTEAPPCARDWAPURL"	name="LGD_MPILOTTEAPPCARDWAPURL"	value="<?=$LGD_MPILOTTEAPPCARDWAPURL ?>"/>
<input type="hidden" id="LGD_BUYERID"			name="LGD_BUYERID"				value="<?=$userid ?>"/>

<!--
������û�� ��LGD_RETURN_MERT_CUSTOM_PARAM�� = ��Y���� ��� ��������� ���� retunurl �� �״�� ����
*���ǻ���
��������� �Ķ���ʹ� LGD_ �� ���۵� �� ����.

<input type="hidden" id="LGD_RETURN_MERT_CUSTOM_PARAM"	name="LGD_RETURN_MERT_CUSTOM_PARAM"	value="Y�� />
<input type="hidden" id="CUSTOM_PARAMETER1"	name="CUSTOM_PARAMETER1"	value="�������� �Ķ���� �� 1���Դϴ�" />
<input type="hidden" id="CUSTOM_PARAMETER2"	name="CUSTOM_PARAMETER2"	value="�������� �Ķ���� �� 2���Դϴ١� />
-->

<!-- ISP(����/BC)�������� ���� -->
<input type="hidden" id="LGD_KVPMISPWAPURL"			name="LGD_KVPMISPWAPURL"			value="<?=$LGD_KVPMISPWAPURL ?>"/>
<input type="hidden" id="LGD_KVPMISPCANCELURL"		name="LGD_KVPMISPCANCELURL"			value="<?=$LGD_KVPMISPCANCELURL ?>"/>

<!-- ������ü �������� ���� -->
<input type="hidden" id="LGD_MTRANSFERWAPURL"		name="LGD_MTRANSFERWAPURL"			value="<?=$LGD_MTRANSFERWAPURL ?>"/>
<input type="hidden" id="LGD_MTRANSFERCANCELURL"	name="LGD_MTRANSFERCANCELURL"		value="<?=$LGD_MTRANSFERCANCELURL ?>"/>

<!-- ����� OS�� ISP(����/BC)����/������ü ���� ���� -->
<input type="hidden" id="LGD_KVPMISPAUTOAPPYN"		name="LGD_KVPMISPAUTOAPPYN"			value="<?=$LGD_KVPMISPAUTOAPPYN ?>"/>
<input type="hidden" id="LGD_MTRANSFERAUTOAPPYN"	name="LGD_MTRANSFERAUTOAPPYN"		value="<?=$LGD_MTRANSFERAUTOAPPYN ?>"/>


<input type="hidden" id="LGD_RESPCODE"				name="LGD_RESPCODE"					value=""/>
<input type="hidden" id="LGD_RESPMSG"				name="LGD_RESPMSG"					value=""/>
<input type="hidden" id="LGD_PAYKEY"				name="LGD_PAYKEY"					value=""/>

</form>
</body>
</html>

