<?php
function plugin_phpmailer($formId, $submitButtonId) {
    // jQuery를 포함
    jquery();

    $nonce = NONCE;
    $url = DOMAIN . '/?post=plugin_phpmailer_sand_input';
    
    echo <<<EOD
<script nonce="$nonce">
    function handleEmailFormSubmit() {
        $(document).ready(function () {
            $('#$submitButtonId').click(function (e) {
                e.preventDefault(); // 기본 폼 제출 방지

                var form = $('#$formId')[0];
                var formData = new FormData(form);

                // 필드가 존재하는 경우에만 값을 가져옴
                var subject = formData.get('email_subject') ? formData.get('email_subject').trim() : '';

                if (!subject) {
                    alert("제목을 입력해 주세요.");
                    return;
                }

                var body = '';
                formData.forEach(function(value, key) {
                    if (key !== 'email_subject') {
                        body += key + ": " + value.trim() + "<br>";
                    }
                });

                if (!body) {
                    alert("본문을 입력해 주세요.");
                    return;
                }

                var newFormData = new FormData();
                newFormData.set('email_subject', subject);
                newFormData.set('email_body', body);

                $.ajax({
                    url: "$url",
                    type: 'POST',
                    data: newFormData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            alert("이메일이 성공적으로 전송되었습니다!");
                        } else {
                            var errorMessages = {
                                1: "메일러 오류: " + jsonResponse.errorMessage,
                                2: "파일 업로드에 실패했습니다.",
                                3: "유효하지 않은 이메일 주소입니다.",
                                4: "도메인에 MX 레코드가 없습니다.",
                                5: "MX 레코드를 가져오는 데 실패했습니다.",
                                6: "이메일 주소가 유효하지 않습니다.",
                                7: "제목에 허용되지 않는 문자가 포함되어 있습니다.",
                                8: "제목이 너무 깁니다."
                            };
                            var message = errorMessages[jsonResponse.errorCode] || "알 수 없는 오류가 발생했습니다.";
                            alert(message);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                        alert("AJAX 오류: " + textStatus);
                    }
                });
            });
        });
    }
    handleEmailFormSubmit();
</script>
EOD;
}

?>
