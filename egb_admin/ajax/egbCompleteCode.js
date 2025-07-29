function egbCompleteCode(formId) {
    // ajax 실행에 따른 메시지 처리를 사용자가 직접 작성
    switch (formId) {
        case 'ex':
            alert('Error 3: 서버에서 처리할 수 없습니다.');
            break;
        default:
            console.log(formId);
            break;
    }
}