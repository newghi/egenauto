function egbCompleteCode(formId) {
    // ajax 실행에 따른 메시지 처리를 사용자가 직접 작성
    switch (formId) {
        case 0:
            //아무일도 일어나지 않음
            break;
        default:
			console.log('폼전송 완료 : ' + formId);
            break;
    }
}