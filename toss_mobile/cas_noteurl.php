<?php
    /*
     * [���� �������ó��(DB) ������]
     *
     * 1) ������ ������ ���� hashdata�� ������ �ݵ�� �����ϼž� �մϴ�.
     *
     */
	
    $LGD_RESPCODE            = $_POST["LGD_RESPCODE"];             // �����ڵ�: 0000(����) �׿� ����
    $LGD_RESPMSG             = $_POST["LGD_RESPMSG"];              // ����޼���
    $LGD_MID                 = $_POST["LGD_MID"];                  // �������̵�
    $LGD_OID                 = $_POST["LGD_OID"];                  // �ֹ���ȣ
    $LGD_AMOUNT              = $_POST["LGD_AMOUNT"];               // �ŷ��ݾ�
    $LGD_TID                 = $_POST["LGD_TID"];                  // �佺���̸������� �ο��� �ŷ���ȣ
    $LGD_PAYTYPE             = $_POST["LGD_PAYTYPE"];              // ���������ڵ�
    $LGD_PAYDATE             = $_POST["LGD_PAYDATE"];              // �ŷ��Ͻ�(�����Ͻ�/��ü�Ͻ�)
    $LGD_HASHDATA            = $_POST["LGD_HASHDATA"];             // �ؽ���
    $LGD_FINANCECODE         = $_POST["LGD_FINANCECODE"];          // ��������ڵ�(�����ڵ�)
    $LGD_FINANCENAME         = $_POST["LGD_FINANCENAME"];          // ��������̸�(�����̸�)
    $LGD_ESCROWYN            = $_POST["LGD_ESCROWYN"];             // ����ũ�� ���뿩��
    $LGD_TIMESTAMP           = $_POST["LGD_TIMESTAMP"];            // Ÿ�ӽ�����
    $LGD_ACCOUNTNUM          = $_POST["LGD_ACCOUNTNUM"];           // ���¹�ȣ(�������Ա�)
    $LGD_CASTAMOUNT          = $_POST["LGD_CASTAMOUNT"];           // �Ա��Ѿ�(�������Ա�)
    $LGD_CASCAMOUNT          = $_POST["LGD_CASCAMOUNT"];           // ���Աݾ�(�������Ա�)
    $LGD_CASFLAG             = $_POST["LGD_CASFLAG"];              // �������Ա� �÷���(�������Ա�) - 'R':�����Ҵ�, 'I':�Ա�, 'C':�Ա����
    $LGD_CASSEQNO            = $_POST["LGD_CASSEQNO"];             // �Աݼ���(�������Ա�)
    $LGD_CASHRECEIPTNUM      = $_POST["LGD_CASHRECEIPTNUM"];       // ���ݿ����� ���ι�ȣ
    $LGD_CASHRECEIPTSELFYN   = $_POST["LGD_CASHRECEIPTSELFYN"];    // ���ݿ����������߱������� Y: �����߱��� ����, �׿� : ������
    $LGD_CASHRECEIPTKIND     = $_POST["LGD_CASHRECEIPTKIND"];      // ���ݿ����� ���� 0: �ҵ������ , 1: ����������
	$LGD_PAYER     			 = $_POST["LGD_PAYER"];      			// �Ա��ڸ�
	
    /*
     * ��������
     */
    $LGD_BUYER               = $_POST["LGD_BUYER"];                // ������
    $LGD_PRODUCTINFO         = $_POST["LGD_PRODUCTINFO"];          // ��ǰ��
    $LGD_BUYERID             = $_POST["LGD_BUYERID"];              // ������ ID
    $LGD_BUYERADDRESS        = $_POST["LGD_BUYERADDRESS"];         // ������ �ּ�
    $LGD_BUYERPHONE          = $_POST["LGD_BUYERPHONE"];           // ������ ��ȭ��ȣ
    $LGD_BUYEREMAIL          = $_POST["LGD_BUYEREMAIL"];           // ������ �̸���
    $LGD_BUYERSSN            = $_POST["LGD_BUYERSSN"];             // ������ �ֹι�ȣ
    $LGD_PRODUCTCODE         = $_POST["LGD_PRODUCTCODE"];          // ��ǰ�ڵ�
    $LGD_RECEIVER            = $_POST["LGD_RECEIVER"];             // ������
    $LGD_RECEIVERPHONE       = $_POST["LGD_RECEIVERPHONE"];        // ������ ��ȭ��ȣ
    $LGD_DELIVERYINFO        = $_POST["LGD_DELIVERYINFO"];         // �����
      
	$LGD_MERTKEY = "93200ff88799726d42cee4e94b4a4589";  //�佺���̸������� �߱��� ����Ű�� ������ �ֽñ� �ٶ��ϴ�.
	
    $LGD_HASHDATA2 = md5($LGD_MID.$LGD_OID.$LGD_AMOUNT.$LGD_RESPCODE.$LGD_TIMESTAMP.$LGD_MERTKEY);
    
    /*
     * ���� ó����� ���ϸ޼���
     *
     * OK  : ���� ó����� ����
     * �׿� : ���� ó����� ����
     *
     * �� ���ǻ��� : ������ 'OK' �����̿��� �ٸ����ڿ��� ���ԵǸ� ����ó�� �ǿ��� �����Ͻñ� �ٶ��ϴ�.
     */
    $resultMSG = "������� ���� DBó��(LGD_CASNOTEURL) ������� �Է��� �ֽñ� �ٶ��ϴ�.";

    
    if ( $LGD_HASHDATA2 == $LGD_HASHDATA ) { //�ؽ��� ������ �����̸�
        if ( "0000" == $LGD_RESPCODE ){ //������ �����̸�

			include '../class/class.DbCon.php';

        	if( "R" == $LGD_CASFLAG ) {
                /*
                 * ������ �Ҵ� ���� ��� ���� ó��(DB) �κ�
                 * ���� ��� ó���� �����̸� "OK"
                 */    
                //if( ������ �Ҵ� ���� ����ó����� ���� ) 

				$sql = "insert into ks_order_account (LGD_BUYERID,LGD_PAYER,LGD_OID,LGD_AMOUNT,LGD_TID,LGD_PAYTYPE,LGD_PAYDATE,LGD_FINANCECODE,LGD_FINANCENAME,LGD_ESCROWYN,LGD_TIMESTAMP,LGD_ACCOUNTNUM,LGD_CASTAMOUNT,LGD_CASHRECEIPTNUM,LGD_CASHRECEIPTSELFYN,LGD_CASHRECEIPTKIND) values ('$LGD_BUYERID','$LGD_PAYER','$LGD_OID','$LGD_AMOUNT','$LGD_TID','$LGD_PAYTYPE','$LGD_PAYDATE','$LGD_FINANCECODE','$LGD_FINANCENAME','$LGD_ESCROWYN','$LGD_TIMESTAMP','$LGD_ACCOUNTNUM','$LGD_CASTAMOUNT','$LGD_CASHRECEIPTNUM','$LGD_CASHRECEIPTSELFYN','$LGD_CASHRECEIPTKIND')";
				$result = mysql_query($sql);

                $resultMSG = "OK";   
        	}else if( "I" == $LGD_CASFLAG ) {
 	            /*
    	         * ������ �Ա� ���� ��� ���� ó��(DB) �κ�
        	     * ���� ��� ó���� �����̸� "OK"
            	 */    
            	//if( ������ �Ա� ���� ����ó����� ���� ) 

					$sql = "update ks_order_account set LGD_PAYDATE_IN='$LGD_PAYDATE' where LGD_BUYERID='$LGD_BUYERID' and LGD_OID='$LGD_OID'";
					$result = mysql_query($sql);

					$sql = "update ks_order set status='�Ա�Ȯ��' where userid='$LGD_BUYERID' and reg_date='$LGD_OID'";
					$result = mysql_query($sql);

            	$resultMSG = "OK";
        	}else if( "C" == $LGD_CASFLAG ) {
 	            /*
    	         * ������ �Ա���� ���� ��� ���� ó��(DB) �κ�
        	     * ���� ��� ó���� �����̸� "OK"
            	 */    
            	//if( ������ �Ա���� ���� ����ó����� ���� ) 
            	$resultMSG = "OK";
        	}
        } else { //������ �����̸�
            /*
             * �ŷ����� ��� ���� ó��(DB) �κ�
             * ������� ó���� �����̸� "OK"
             */  
            //if( �������� ����ó����� ���� ) 
            $resultMSG = "OK";     
        }
    } else { //�ؽ����� ������ �����̸�
        /*
         * hashdata���� ���� �α׸� ó���Ͻñ� �ٶ��ϴ�. 
         */      
        $resultMSG = "������� ���� DBó��(LGD_CASNOTEURL) �ؽ��� ������ �����Ͽ����ϴ�.";     
    }
    
    echo $resultMSG;
?>
