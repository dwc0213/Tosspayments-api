# Tosspayments-api
Tosspayments api Linkage
<h3>홈페이지 토스페이먼츠 api연동해서 온라인 결제 구현</h3>

쇼핑몰 홈페이지에 온라인 결제를 Tosspayments api를 연동해서 결제

1. mall.conf에 상점 키 값과 아이디 값을 입력하고 환경설정이 접근가능한 경로를 configpath를 통해 설정한다.

2. 파라미터 LGD_RETURNURL에 인증키를 받기위한 페이지 URL을 설정한다.

3. payreq_crosspaltform.php에서 값이 잘 넘어가는지 확인하기 위해 insert.php을 추가하여 tmp 임시테이블로 저장한다.

4. 최정결제가 됐을때 정보를 저장하기 위해 success.php에 임시테이블 정보를 삭제하고 결제가 완료됐을때의 정보를 저장한다.
