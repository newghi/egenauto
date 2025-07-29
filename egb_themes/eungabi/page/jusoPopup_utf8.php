<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<?php
    $ADDR['inputYn'] = $_POST['inputYn'] ?? null;
    $ADDR['roadFullAddr'] = $_POST['roadFullAddr'] ?? null;
    $ADDR['roadAddrPart1'] = $_POST['roadAddrPart1'] ?? null;
    $ADDR['roadAddrPart2'] = $_POST['roadAddrPart2'] ?? null;
    $ADDR['engAddr'] = $_POST['engAddr'] ?? null;
    $ADDR['jibunAddr'] = $_POST['jibunAddr'] ?? null;
    $ADDR['zipNo'] = $_POST['zipNo'] ?? null;
    $ADDR['addrDetail'] = $_POST['addrDetail'] ?? null;
    $ADDR['admCd'] = $_POST['admCd'] ?? null;
    $ADDR['rnMgtSn'] = $_POST['rnMgtSn'] ?? null;
    $ADDR['bdMgtSn'] = $_POST['bdMgtSn'] ?? null;
    $ADDR['detBdNmList'] = $_POST['detBdNmList'] ?? null;
    $ADDR['bdNm'] = $_POST['bdNm'] ?? null;
    $ADDR['bdKdcd'] = $_POST['bdKdcd'] ?? null;
    $ADDR['siNm'] = $_POST['siNm'] ?? null;
    $ADDR['sggNm'] = $_POST['sggNm'] ?? null;
    $ADDR['emdNm'] = $_POST['emdNm'] ?? null;
    $ADDR['liNm'] = $_POST['liNm'] ?? null;
    $ADDR['rn'] = $_POST['rn'] ?? null;
    $ADDR['udrtYn'] = $_POST['udrtYn'] ?? null;
    $ADDR['buldMnnm'] = $_POST['buldMnnm'] ?? null;
    $ADDR['buldSlno'] = $_POST['buldSlno'] ?? null;
    $ADDR['mtYn'] = $_POST['mtYn'] ?? null;
    $ADDR['lnbrMnnm'] = $_POST['lnbrMnnm'] ?? null;
    $ADDR['lnbrSlno'] = $_POST['lnbrSlno'] ?? null;
    $ADDR['emdNo'] = $_POST['emdNo'] ?? null;
?>

</head>
<script language="javascript" nonce="<?php echo  NONCE; ?>">
// opener관련 오류가 발생하는 경우 아래 주석을 해지하고, 사용자의 도메인정보를 입력합니다. ("주소입력화면 소스"도 동일하게 적용시켜야 합니다.)
//document.domain = "<?php echo  DOMAIN; ?>";

/*
		모의 해킹 테스트 시 팝업API를 호출하시면 IP가 차단 될 수 있습니다. 
		주소팝업API를 제외하시고 테스트 하시기 바랍니다.
*/

function init() {
    var url = "<?php echo DOMAIN.'/page/signup'; ?>";
    var confmKey = "devU01TX0FVVEgyMDI0MDkyODE4NTgwMjExNTExNzg=";
    var resultType = "4"; // 도로명주소 검색결과 화면 출력 유형

    // 팝업에서 주소 데이터를 전달할 때는 실제 변수 값을 전달해야 합니다.
    var inputYn = "<?php echo isset($ADDR['inputYn']) ? $ADDR['inputYn'] : ''; ?>";
    var roadFullAddr = "<?php echo isset($ADDR['roadFullAddr']) ? $ADDR['roadFullAddr'] : ''; ?>";
    var roadAddrPart1 = "<?php echo isset($ADDR['roadAddrPart1']) ? $ADDR['roadAddrPart1'] : ''; ?>";
    var addrDetail = "<?php echo isset($ADDR['addrDetail']) ? $ADDR['addrDetail'] : ''; ?>";
    var roadAddrPart2 = "<?php echo isset($ADDR['roadAddrPart2']) ? $ADDR['roadAddrPart2'] : ''; ?>";
    var jibunAddr = "<?php echo isset($ADDR['jibunAddr']) ? $ADDR['jibunAddr'] : ''; ?>";
    var zipNo = "<?php echo isset($ADDR['zipNo']) ? $ADDR['zipNo'] : ''; ?>";

    if (inputYn !== "Y") {
        document.form.confmKey.value = confmKey;
        document.form.returnUrl.value = url;
        document.form.resultType.value = resultType;
        document.form.action = "https://business.juso.go.kr/addrlink/addrLinkUrl.do"; // 인터넷망
        document.form.submit();
    } else {
        opener.jusoCallBack(roadFullAddr, roadAddrPart1, addrDetail, roadAddrPart2, jibunAddr, zipNo);
        window.close();
    }
	console.log('실행됨');
}

</script>
<body onload="init();">
	<form id="form" name="form" method="post">
		<input type="hidden" id="confmKey" name="confmKey" value=""/>
		<input type="hidden" id="returnUrl" name="returnUrl" value=""/>
		<input type="hidden" id="resultType" name="resultType" value=""/>
		<!-- 해당시스템의 인코딩타입이 EUC-KR일경우에만 추가 START-->
		<!--input type="hidden" id="encodingType" name="encodingType" value="EUC-KR"/-->
		<!-- 해당시스템의 인코딩타입이 EUC-KR일경우에만 추가 END-->
	</form>
</body>
</html>