<?php
    /*
     * [결제취소 요청 페이지]
     *
	 * 매뉴얼 "6. 결제 취소를 위한 개발사항(API)"의 "단계 3. 결제 취소 요청 및 요청 결과 처리" 참고
     * 토스페이먼츠으로 부터 내려받은 거래번호(LGD_TID)를 가지고 취소 요청을 합니다.(파라미터 전달시 POST를 사용하세요)
     * (승인시 토스페이먼츠으로 부터 내려받은 PAYKEY와 혼동하지 마세요.)
     */
    $CST_PLATFORM               = $_POST["CST_PLATFORM"];					//토스페이먼츠 결제 서비스 선택(test:테스트, service:서비스)
    $CST_MID                    = $_POST["CST_MID"];						//상점아이디(토스페이먼츠으로 부터 발급받으신 상점아이디를 입력하세요)
																			//테스트 아이디는 't'를 반드시 제외하고 입력하세요.
    $LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;  //상점아이디(자동생성)    
    $LGD_TID                	= $_POST["LGD_TID"];						//토스페이먼츠으로 부터 내려받은 거래번호(LGD_TID)
    
 	/* ※ 중요
	* 환경설정 파일의 경우 반드시 외부에서 접근이 가능한 경로에 두시면 안됩니다.
	* 해당 환경파일이 외부에 노출이 되는 경우 해킹의 위험이 존재하므로 반드시 외부에서 접근이 불가능한 경로에 두시기 바랍니다. 
	* 예) [Window 계열] C:\inetpub\wwwroot\lgdacom ==> 절대불가(웹 디렉토리)
	*/
 	$configPath 				= "C:/lgdacom"; 						 //토스페이먼츠에서 제공한 환경파일("/conf/lgdacom.conf") 위치 지정.   
    
    require_once("./lgdacom/XPayClient.php");
    
	// (1) XpayClient의 사용을 위한 xpay 객체 생성
	// (2) Init: XPayClient 초기화(환경설정 파일 로드) 
	// configPath: 설정파일
	// CST_PLATFORM: - test, service 값에 따라 lgdacom.conf의 test_url(test) 또는 url(srvice) 사용
	//				- test, service 값에 따라 테스트용 또는 서비스용 아이디 생성
	$xpay = new XPayClient($configPath, $CST_PLATFORM);

	// (3) Init_TX: 메모리에 mall.conf, lgdacom.conf 할당 및 트랜잭션의 고유한 키 TXID 생성
    $xpay->Init_TX($LGD_MID);
    $xpay->Set("LGD_TXNAME", "Cancel");
    $xpay->Set("LGD_TID", $LGD_TID);
    
    /*
     * 1. 결제취소 요청 결과처리
     *
     * 취소결과 리턴 파라미터는 연동메뉴얼을 참고하시기 바랍니다.
     */
	// (4) TX: lgdacom.conf에 설정된 URL로 소켓 통신하여 최종 인증요청, 결과값으로 true, false 리턴
    if ($xpay->TX()) {
		// (5) 결제취소요청 결과 처리
        //1)결제취소결과 화면처리(성공,실패 결과 처리를 하시기 바랍니다.)
        echo "결제 취소요청이 완료되었습니다.  <br>";
        echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
        echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";
    }else {
        //2)API 요청 실패 화면처리
        echo "결제 취소요청이 실패하였습니다.  <br>";
        echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
        echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";
    }
?>
