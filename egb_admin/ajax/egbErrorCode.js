function egbErrorCode(error) {
    // 에러가 객체일 경우 처리
    if (typeof error == 'object') {
        if (error.errorCode && error.errorCode.includes("Request with GET/HEAD method cannot have body")) {
            alert("GET/HEAD 요청에는 본문을 포함할 수 없습니다. 요청 방식을 확인하세요.");
        } else if (error.errorCode && error.errorCode.includes("Failed to execute 'fetch'")) {
            alert("Fetch 요청 실패: " + error.errorCode);
        } else if (error.errorCode && error.errorCode.includes("Unexpected token")) {
			 alert("form 요청 경로가 없거나 반환 정보가 json 형식이 아닙니다.");
        } else if (error.errorCode && error.errorCode.includes("Failed to fetch")) {
			 alert("Fetch 요청 실패: " + error.errorCode);
        }{
            alert(JSON.stringify(error) + ' : 알 수 없는 객체 에러가 발생했습니다.');
		console.log(error);
        }
		console.log(error.errorCode);
        return;
    }

    // 에러 코드에 따른 메시지 처리
    switch (error) {
        case 1:
            alert('ajax를 통해 에러코드 1번 반환 받은거 테스트 성공');
            break;
        case 2:
            alert('Error 2: 요청한 데이터가 존재하지 않습니다.');
            break;
        case 3:
            alert('Error 3: 서버에서 처리할 수 없습니다.');
            break;
        default:
            alert(error + ' errorerrorerror: 알 수 없는 에러가 발생했습니다.');
            break;
    }
}