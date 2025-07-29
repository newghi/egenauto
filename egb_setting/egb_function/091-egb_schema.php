<?php

function egb_schema_autoload($type, $dom, $data = []) {
    $result = null;
    $func = 'egb_schema_' . strtolower($type);
    $schema_path = ROOT . DS . 'egb_setting' . DS . 'egb_schema' . DS . $func . '.php';

    if (file_exists($schema_path)) {
        require_once $schema_path;
        if (function_exists($func)) {
            if (!empty($data)) {
                $result = $func($dom, $data);
            } else {
                $result = $func($dom);
            }
        }
    }
    return $result;
}

function egb_schema($type, $dom, $data = []){
    $result = null;
        switch ($type) {
        case '3DModel': // 3D 모델 - 3차원 디지털 모델링 객체를 나타내는 스키마
            break;
        case 'AMRadioChannel': // AM 라디오 채널 - AM 라디오 방송 채널 정보
            break;
        case 'APIReference': // API 참조 - API 문서나 참조 정보
            break;
        case 'AboutPage': // 소개 페이지 - 회사나 조직의 소개 페이지
            break;
        case 'AcceptAction': // 수락 액션 - 제안이나 초대를 수락하는 행동
            break;
        case 'Accommodation': // 숙박 시설 - 호텔, 모텔, 펜션 등 숙박 관련 시설
            break;
        case 'AccountingService': // 회계 서비스 - 회계 및 세무 관련 서비스
            break;
        case 'AchieveAction': // 달성 액션 - 목표나 성과를 달성하는 행동
            break;
        case 'Action': // 액션 - 사용자가 수행하는 모든 행동의 기본 타입
            break;
        case 'ActionAccessSpecification': // 액션 접근 명세 - 액션의 접근 권한과 조건
            break;
        case 'ActionStatusType': // 액션 상태 타입 - 액션의 진행 상태 (대기, 진행중, 완료 등)
            break;
        case 'ActivateAction': // 활성화 액션 - 서비스나 기능을 활성화하는 행동
            break;
        case 'AddAction': // 추가 액션 - 항목을 추가하는 행동
            break;
        case 'AdministrativeArea': // 행정 구역 - 국가, 주, 도시 등 행정적 구분
            break;
        case 'AdultEntertainment': // 성인 오락 - 성인 대상 엔터테인먼트 시설
            break;
        case 'AdultOrientedEnumeration': // 성인 대상 열거 - 성인 전용 콘텐츠 구분
            break;
        case 'AdvertiserContentArticle': // 광고주 콘텐츠 기사 - 광고주가 제공하는 기사
            break;
        case 'AggregateOffer': // 집계 제안 - 여러 판매자의 제품을 모아놓은 제안
            break;
        case 'AggregateRating': // 집계 평점 - 여러 리뷰의 평점을 종합한 평점
            break;
        case 'AgreeAction': // 동의 액션 - 의견이나 제안에 동의하는 행동
            break;
        case 'Airline': // 항공사 - 항공 운송 서비스를 제공하는 회사
            break;
        case 'Airport': // 공항 - 항공기 이착륙 및 승객 처리 시설
            break;
        case 'AlignmentObject': // 정렬 객체 - 교육 콘텐츠와 표준 간의 정렬 정보
            break;
        case 'AllocateAction': // 할당 액션 - 리소스를 할당하는 행동
            break;
        case 'AmpStory': // AMP 스토리 - Google AMP 스토리 형식의 콘텐츠
            break;
        case 'AmusementPark': // 놀이공원 - 놀이기구와 엔터테인먼트 시설
            break;
        case 'AnalysisNewsArticle': // 분석 뉴스 기사 - 심층 분석이 포함된 뉴스 기사
            break;
        case 'AnatomicalStructure': // 해부학적 구조 - 인체의 해부학적 부위
            break;
        case 'AnatomicalSystem': // 해부학적 시스템 - 인체의 생리학적 시스템
            break;
        case 'AnimalShelter': // 동물 보호소 - 유기동물 보호 및 입양 시설
            break;
        case 'Answer': // 답변 - 질문에 대한 답변
            break;
        case 'Apartment': // 아파트 - 공동 주거 시설의 개별 단위
            break;
        case 'ApartmentComplex': // 아파트 단지 - 여러 아파트가 모인 주거 단지
            break;
        case 'AppendAction': // 추가 액션 - 기존 항목에 내용을 추가하는 행동
            break;
        case 'ApplyAction': // 신청 액션 - 지원서나 신청서를 제출하는 행동
            break;
        case 'ApprovedIndication': // 승인 표시 - 의료 제품의 승인 상태 표시
            break;
        case 'Aquarium': // 수족관 - 수생 생물을 전시하는 시설
            break;
        case 'ArchiveComponent': // 아카이브 구성요소 - 보관된 자료의 구성 요소
            break;
        case 'ArchiveOrganization': // 아카이브 조직 - 자료 보관 및 관리 조직
            break;
        case 'ArriveAction': // 도착 액션 - 특정 장소에 도착하는 행동
            break;
        case 'ArtGallery': // 미술관 - 예술 작품을 전시하는 시설
            break;
        case 'Artery': // 동맥 - 혈관의 동맥 부분
            break;
        case 'Article': // 기사 - 뉴스, 블로그, 잡지 등의 기사
            break;
        case 'AskAction': // 질문 액션 - 질문을 하는 행동
            break;
        case 'AskPublicNewsArticle': // 공개 질문 뉴스 기사 - 독자 질문에 답변하는 기사
            break;
        case 'AssessAction': // 평가 액션 - 성과나 결과를 평가하는 행동
            break;
        case 'AssignAction': // 할당 액션 - 작업이나 역할을 할당하는 행동
            break;
        case 'Atlas': // 지도책 - 지리적 정보를 담은 책이나 지도 모음
            break;
        case 'Attorney': // 변호사 - 법률 서비스를 제공하는 변호사
            break;
        case 'Audience': // 청중 - 콘텐츠나 이벤트의 대상 청중
            break;
        case 'AudioObject': // 오디오 객체 - 오디오 파일이나 스트림
            break;
        case 'AudioObjectSnapshot': // 오디오 객체 스냅샷 - 오디오의 특정 시점 스냅샷
            break;
        case 'Audiobook': // 오디오북 - 음성으로 읽어주는 책
            break;
        case 'AuthorizeAction': // 승인 액션 - 권한을 부여하거나 승인하는 행동
            break;
        case 'AutoBodyShop': // 자동차 바디샵 - 자동차 수리 및 도장 전문점
            break;
        case 'AutoDealer': // 자동차 딜러 - 자동차 판매 대리점
            break;
        case 'AutoPartsStore': // 자동차 부품점 - 자동차 부품 판매점
            break;
        case 'AutoRental': // 자동차 렌탈 - 자동차 대여 서비스
            break;
        case 'AutoRepair': // 자동차 수리 - 자동차 정비 및 수리 서비스
            break;
        case 'AutoWash': // 자동세차 - 자동차 세차 서비스
            break;
        case 'AutomatedTeller': // ATM - 자동화된 현금 인출기
            break;
        case 'AutomotiveBusiness': // 자동차 관련 사업 - 자동차 관련 모든 비즈니스
            break;
        case 'BackgroundNewsArticle': // 배경 뉴스 기사 - 사건의 배경 정보를 제공하는 기사
            break;
        case 'Bakery': // 베이커리 - 빵과 제과점
            break;
        case 'BankAccount': // 은행 계좌 - 금융 계좌 정보
            break;
        case 'BankOrCreditUnion': // 은행 또는 신용조합 - 금융 기관
            break;
        case 'BarOrPub': // 바 또는 펍 - 주류를 제공하는 엔터테인먼트 시설
            break;
        case 'Barcode': // 바코드 - 상품 식별을 위한 바코드
            break;
        case 'Beach': // 해변 - 해안가의 모래사장
            break;
        case 'BeautySalon': // 미용실 - 헤어, 메이크업 등 미용 서비스
            break;
        case 'BedAndBreakfast': // B&B - 소규모 숙박 및 조식 제공 시설
            break;
        case 'BedDetails': // 침대 상세정보 - 숙박 시설의 침대 정보
            break;
        case 'BedType': // 침대 타입 - 침대의 종류 (싱글, 더블, 킹 등)
            break;
        case 'BefriendAction': // 친구 맺기 액션 - 소셜 네트워크에서 친구 관계 형성
            break;
        case 'BikeStore': // 자전거점 - 자전거 판매 및 수리점
            break;
        case 'BioChemEntity': // 생화학 엔티티 - 생화학적 분자나 구조
            break;
        case 'Blog': // 블로그 - 개인 또는 조직의 웹 로그
            break;
        case 'BlogPosting': // 블로그 포스팅 - 블로그에 게시된 개별 글
            break;
        case 'BloodTest': // 혈액 검사 - 의료 혈액 검사 정보
            break;
        case 'BoardingPolicyType': // 탑승 정책 타입 - 항공편 탑승 관련 정책
            break;
        case 'BoatReservation': // 보트 예약 - 선박 여행 예약
            break;
        case 'BoatTerminal': // 보트 터미널 - 선박 승하차 시설
            break;
        case 'BoatTrip': // 보트 여행 - 선박을 이용한 여행
            break;
        case 'BodyMeasurementTypeEnumeration': // 신체 측정 타입 열거 - 신체 측정 항목 구분
            break;
        case 'BodyOfWater': // 수역 - 호수, 강, 바다 등 물이 있는 지역
            break;
        case 'Bone': // 뼈 - 인체의 뼈 구조
            break;
        case 'Book': // 책 - 출판된 도서
            break;
        case 'BookFormatType': // 책 형식 타입 - 책의 형식 (하드커버, 페이퍼백 등)
            break;
        case 'BookSeries': // 책 시리즈 - 연속된 책들의 시리즈
            break;
        case 'BookStore': // 서점 - 책을 판매하는 매장
            break;
        case 'BookmarkAction': // 북마크 액션 - 웹페이지나 콘텐츠를 북마크하는 행동
            break;
        case 'Boolean': // 불린 - 참/거짓 값을 나타내는 데이터 타입
            break;
        case 'BorrowAction': // 대여 액션 - 물건을 빌리는 행동
            break;
        case 'BowlingAlley': // 볼링장 - 볼링을 즐길 수 있는 시설
            break;
        case 'BrainStructure': // 뇌 구조 - 뇌의 해부학적 구조
            break;
        case 'Brand': // 브랜드 - 제품이나 서비스의 브랜드
            break;
        case 'BreadcrumbList': // 브레드크럼 리스트 - 웹사이트 네비게이션 경로
            break;
        case 'Brewery': // 양조장 - 맥주나 술을 제조하는 시설
            break;
        case 'Bridge': // 다리 - 도로나 철도가 지나가는 구조물
            break;
        case 'BroadcastChannel': // 방송 채널 - TV나 라디오의 방송 채널
            break;
        case 'BroadcastEvent': // 방송 이벤트 - TV나 라디오 프로그램의 방송
            break;
        case 'BroadcastFrequencySpecification': // 방송 주파수 사양 - 방송 주파수에 대한 상세 정보
            break;
        case 'BroadcastService': // 방송 서비스 - TV나 라디오 방송 서비스
            break;
        case 'BrokerageAccount': // 중개 계좌 - 증권이나 투자 중개 계좌
            break;
        case 'BuddhistTemple': // 불교 사원 - 불교 예배 및 수행 시설
            break;
        case 'BusOrCoach': // 버스 또는 코치 - 대중교통 차량
            break;
        case 'BusReservation': // 버스 예약 - 버스 좌석 예약
            break;
        case 'BusStation': // 버스 터미널 - 버스 승하차 시설
            break;
        case 'BusStop': // 버스 정류장 - 버스 승하차 지점
            break;
        case 'BusTrip': // 버스 여행 - 버스를 이용한 여행
            break;
        case 'BusinessAudience': // 비즈니스 고객층 - 기업 대상 고객
            break;
        case 'BusinessEntityType': // 사업체 유형 - 기업의 법적 형태
            break;
        case 'BusinessEvent': // 비즈니스 이벤트 - 기업 관련 행사
            break;
        case 'BusinessFunction': // 비즈니스 기능 - 기업의 업무 기능
            break;
        case 'BuyAction': // 구매 액션 - 물건을 사는 행동
            break;
        case 'CDCPMDRecord': // CDC PMD 기록 - 질병통제예방센터의 의료 기록
            break;
        case 'CableOrSatelliteService': // 케이블/위성 서비스 - TV 방송 서비스
            break;
        case 'CafeOrCoffeeShop': // 카페/커피숍 - 음료와 간단한 식사를 제공하는 매장
            break;
        case 'Campground': // 캠프장 - 야영 시설
            break;
        case 'CampingPitch': // 캠핑 구역 - 개별 캠핑 공간
            break;
        case 'Canal': // 운하 - 인공 수로
            break;
        case 'CancelAction': // 취소 액션 - 예약이나 주문을 취소하는 행동
            break;
        case 'Car': // 자동차 - 개인용 운송 수단
            break;
        case 'CarUsageType': // 자동차 사용 유형 - 자동차 이용 방식
            break;
        case 'Casino': // 카지노 - 도박 시설
            break;
        case 'CategoryCode': // 카테고리 코드 - 분류 체계의 코드
            break;
        case 'CategoryCodeSet': // 카테고리 코드 세트 - 분류 코드 모음
            break;
        case 'CatholicChurch': // 천주교회 - 카톨릭 예배 시설
            break;
        case 'Cemetery': // 묘지 - 매장 시설
            break;
        case 'Certification': // 인증 - 자격이나 표준 인증
            break;
        case 'CertificationStatusEnumeration': // 인증 상태 열거 - 인증 진행 상태
            break;
        case 'Chapter': // 챕터 - 책이나 문서의 장
            break;
        case 'CheckAction': // 확인 액션 - 상태를 확인하는 행동
            break;
        case 'CheckInAction': // 체크인 액션 - 입장/도착 확인
            break;
        case 'CheckOutAction': // 체크아웃 액션 - 퇴장/출발 확인
            break;
        case 'CheckoutPage': // 결제 페이지 - 온라인 구매 결제 페이지
            break;
        case 'ChemicalSubstance': // 화학 물질 - 화학적 구성 물질
            break;
        case 'ChildCare': // 보육 - 아동 돌봄 서비스
            break;
        case 'ChildrensEvent': // 어린이 행사 - 아동 대상 이벤트
            break;
        case 'ChooseAction': // 선택 액션 - 옵션을 고르는 행동
            break;
        case 'Church': // 교회 - 기독교 예배 시설
            break;
        case 'City': // 도시 - 행정구역으로서의 도시
            break;
        case 'CityHall': // 시청 - 도시 행정 중심 건물
            break;
        case 'CivicStructure': // 공공 시설 - 시민을 위한 공공 건물이나 시설
            break;
        case 'Claim': // 주장 - 사실이나 의견의 진술
            break;
        case 'ClaimReview': // 주장 검토 - 주장의 사실 여부 검증
            break;
        case 'Class': // 클래스 - 분류나 교육 과정
            break;
        case 'Clip': // 클립 - 영상이나 음성의 일부분
            break;
        case 'ClothingStore': // 의류 매장 - 옷을 판매하는 상점
            break;
        case 'Code': // 코드 - 컴퓨터 프로그래밍 코드나 식별자
            break;
        case 'Collection': // 컬렉션 - 여러 항목의 모음이나 집합
            break;
        case 'CollectionPage': // 컬렉션 페이지 - 여러 항목을 모아놓은 웹페이지
            break;
        case 'CollegeOrUniversity': // 대학교 - 고등 교육 기관
            break;
        case 'ComedyClub': // 코미디 클럽 - 코미디 공연장
            break;
        case 'ComedyEvent': // 코미디 이벤트 - 코미디 공연 행사
            break;
        case 'ComicCoverArt': // 만화 표지 아트 - 만화책의 표지 그림
            break;
        case 'ComicIssue': // 만화 호수 - 연재 만화의 각 호
            break;
        case 'ComicSeries': // 만화 시리즈 - 연속된 만화 작품
            break;
        case 'ComicStory': // 만화 이야기 - 만화의 서사 구조
            break;
        case 'Comment': // 댓글 - 게시물에 대한 의견이나 반응
            break;
        case 'CommentAction': // 댓글 작성 액션 - 댓글을 다는 행동
            break;
        case 'CommunicateAction': // 의사소통 액션 - 정보를 주고받는 행동
            break;
        case 'CompleteDataFeed': // 완전한 데이터 피드 - 전체 데이터 스트림
            break;
        case 'CompoundPriceSpecification': // 복합 가격 명세 - 여러 요소로 구성된 가격 정보
            break;
        case 'ComputerLanguage': // 컴퓨터 언어 - 프로그래밍 언어
            break;
        case 'ComputerStore': // 컴퓨터 매장 - 컴퓨터 관련 제품 판매점
            break;
        case 'ConfirmAction': // 확인 액션 - 승인이나 확인하는 행동
            break;
        case 'Consortium': // 컨소시엄 - 협력 단체나 연합체
            break;
        case 'ConstraintNode': // 제약 노드 - 조건이나 제한을 나타내는 노드
            break;
        case 'ConsumeAction': // 소비 액션 - 무언가를 사용하거나 소비하는 행동
            break;
        case 'ContactPage': // 연락처 페이지 - 연락 정보를 담은 웹페이지
            break;
        case 'ContactPoint': // 연락처 지점 - 연락이 가능한 접점
            break;
        case 'ContactPointOption': // 연락처 옵션 - 연락 방법 선택사항
            break;
        case 'Continent': // 대륙 - 지구의 대륙
            break;
        case 'ControlAction': // 제어 액션 - 무언가를 통제하는 행동
            break;
        case 'ConvenienceStore': // 편의점 - 24시간 소매점
            break;
        case 'Conversation': // 대화 - 둘 이상의 참여자 간 의사소통
            break;
        case 'CookAction': // 요리 액션 - 음식을 만드는 행동
            break;
        case 'Cooperative': // 협동조합 - 공동 소유 사업체
            break;
        case 'Corporation': // 기업 - 영리 법인 단체
            break;
        case 'CorrectionComment': // 정정 댓글 - 오류를 수정하는 댓글
            break;
        case 'Country': // 국가 - 독립된 정치적 실체
            break;
        case 'Course': // 강좌 - 교육 과정
            break;
        case 'CourseInstance': // 강좌 인스턴스 - 특정 시점의 강좌 운영
            break;
        case 'Courthouse': // 법원 - 사법 기관 건물
            break;
        case 'CoverArt': // 표지 아트 - 출판물의 표지 디자인
            break;
        case 'CovidTestingFacility': // 코로나 검사 시설 - 코로나19 진단 시설
            break;
        case 'CreateAction': // 생성 액션 - 새로운 것을 만드는 행동
            break;
        case 'CreativeWork': // 창작물 - 창의적 작품이나 콘텐츠
            break;
        case 'CreativeWorkSeason': // 창작물 시즌 - 연속물의 한 시즌
            break;
        case 'CreativeWorkSeries': // 창작물 시리즈 - 연속된 창작물 모음
            break;
        case 'CreditCard': // 신용카드 - 결제용 카드
            break;
        case 'Crematorium': // 화장장 - 시신 화장 시설
            break;
        case 'CriticReview': // 비평가 리뷰 - 전문가의 평가
            break;
        case 'CssSelectorType': // CSS 선택자 유형 - CSS 스타일 지정 방식
            break;
        case 'CurrencyConversionService': // 환율 변환 서비스 - 화폐 교환 서비스
            break;
        case 'DDxElement': // 감별진단 요소 - 의료 진단 구별 요소
            break;
        case 'DanceEvent': // 댄스 이벤트 - 춤 공연 행사
            break;
        case 'DanceGroup': // 댄스 그룹 - 춤 공연 단체
            break;
        case 'DataCatalog': // 데이터 카탈로그 - 데이터 세트 목록
            break;
        case 'DataDownload': // 데이터 다운로드 - 데이터 파일 내려받기
            break;
        case 'DataFeed': // 데이터 피드 - 데이터 스트림
            break;
        case 'DataFeedItem': // 데이터 피드 항목 - 피드의 개별 데이터
            break;
        case 'DataType': // 데이터 타입 - 데이터 형식
            break;
        case 'Dataset': // 데이터셋 - 구조화된 데이터 모음
            break;
        case 'Date': // 날짜 - 달력상의 특정일
            break;
        case 'DateTime': // 날짜시간 - 날짜와 시간 정보
            break;
        case 'DatedMoneySpecification': // 날짜별 금액 명세 - 시간에 따른 금액 정보
            break;
        case 'DayOfWeek': // 요일 - 일주일 중의 날
            break;
        case 'DaySpa': // 데이스파 - 당일 스파 시설
            break;
        case 'DeactivateAction': // 비활성화 액션 - 기능을 끄는 행동
            break;
        case 'DefenceEstablishment': // 국방 시설 - 군사 방어 시설
            break;
        case 'DefinedRegion': // 정의된 지역 - 특정 경계가 있는 구역
            break;
        case 'DefinedTerm': // 정의된 용어 - 명확히 정의된 단어나 구절
            break;
        case 'DefinedTermSet': // 정의된 용어 집합 - 용어 정의 모음
            break;
        case 'DeleteAction': // 삭제 액션 - 제거하는 행동
            break;
        case 'DeliveryChargeSpecification': // 배송료 명세 - 배송 비용 정보
            break;
        case 'DeliveryEvent': // 배송 이벤트 - 물품 전달 행사
            break;
        case 'DeliveryMethod': // 배송 방법 - 물품 전달 방식
            break;
        case 'Demand': // 수요 - 제품이나 서비스에 대한 요구
            break;
        case 'Dentist': // 치과 - 치과 의료 시설
            break;
        case 'DepartAction': // 출발 액션 - 떠나는 행동
            break;
        case 'DepartmentStore': // 백화점 - 종합 소매점
            break;
        case 'DepositAccount': // 예금 계좌 - 은행 저축 계정
            break;
        case 'DiagnosticLab': // 진단 실험실 - 의료 검사 시설
            break;
        case 'DiagnosticProcedure': // 진단 절차 - 의료 진단 과정
            break;
        case 'Diet': // 식이 - 식단이나 영양 섭취 방식
            break;
        case 'DietarySupplement': // 식이 보충제 - 영양 보조제
            break;
        case 'DigitalDocument': // 디지털 문서 - 전자 형식의 문서
            break;
        case 'DigitalDocumentPermission': // 디지털 문서 권한 - 전자 문서 접근 권한
            break;
        case 'DigitalDocumentPermissionType': // 디지털 문서 권한 유형 - 전자 문서 권한의 종류
            break;
        case 'DigitalPlatformEnumeration': // 디지털 플랫폼 열거 - 디지털 플랫폼 유형 목록
            break;
        case 'DisagreeAction': // 비동의 액션 - 동의하지 않는 행동
            break;
        case 'DiscoverAction': // 발견 액션 - 새로운 것을 찾는 행동
            break;
        case 'DiscussionForumPosting': // 토론 게시글 - 포럼의 토론 글
            break;
        case 'DislikeAction': // 싫어요 액션 - 부정적 반응을 표시하는 행동
            break;
        case 'Distance': // 거리 - 두 지점 간의 간격
            break;
        case 'Distillery': // 양조장 - 주류 제조 시설
            break;
        case 'DonateAction': // 기부 액션 - 기부하는 행동
            break;
        case 'DoseSchedule': // 투약 일정 - 약물 복용 계획
            break;
        case 'DownloadAction': // 다운로드 액션 - 파일을 내려받는 행동
            break;
        case 'DrawAction': // 그리기 액션 - 그림을 그리는 행동
            break;
        case 'Drawing': // 그림 - 손으로 그린 예술 작품
            break;
        case 'DrinkAction': // 음료 섭취 액션 - 마시는 행동
            break;
        case 'DriveWheelConfigurationValue': // 구동륜 구성 값 - 자동차 바퀴 구동 방식
            break;
        case 'Drug': // 약물 - 의약품
            break;
        case 'DrugClass': // 약물 분류 - 의약품의 종류나 계열
            break;
        case 'DrugCost': // 약물 비용 - 의약품의 가격 정보
            break;
        case 'DrugCostCategory': // 약물 비용 분류 - 의약품 가격의 범주
            break;
        case 'DrugLegalStatus': // 약물 법적 상태 - 의약품의 법적 허가 상태
            break;
        case 'DrugPregnancyCategory': // 약물 임신 분류 - 임신 중 약물 사용 안전성 등급
            break;
        case 'DrugPrescriptionStatus': // 약물 처방 상태 - 의약품의 처방전 필요 여부
            break;
        case 'DrugStrength': // 약물 강도 - 의약품의 용량이나 농도
            break;
        case 'DryCleaningOrLaundry': // 세탁소 - 드라이클리닝이나 세탁 서비스
            break;
        case 'Duration': // 기간 - 시간의 길이나 지속 시간
            break;
        case 'EUEnergyEfficiencyEnumeration': // EU 에너지 효율 등급 - 유럽연합의 에너지 효율성 분류
            break;
        case 'EatAction': // 식사 액션 - 음식을 먹는 행동
            break;
        case 'EducationEvent': // 교육 이벤트 - 교육 관련 행사
            break;
        case 'EducationalAudience': // 교육 대상 - 교육의 목표 청중
            break;
        case 'EducationalOccupationalCredential': // 교육 직업 자격증 - 교육이나 직업 관련 자격증
            break;
        case 'EducationalOccupationalProgram': // 교육 직업 프로그램 - 교육이나 직업 훈련 과정
            break;
        case 'EducationalOrganization': // 교육 기관 - 교육을 제공하는 조직
            break;
        case 'Electrician': // 전기 기술자 - 전기 관련 서비스 제공자
            break;
        case 'ElectronicsStore': // 전자제품 매장 - 전자기기 판매점
            break;
        case 'ElementarySchool': // 초등학교 - 기초 교육 기관
            break;
        case 'EmailMessage': // 이메일 메시지 - 전자 우편 통신
            break;
        case 'Embassy': // 대사관 - 외교 대표 기관
            break;
        case 'EmergencyService': // 응급 서비스 - 긴급 상황 대응 서비스
            break;
        case 'EmployeeRole': // 직원 역할 - 조직 내 직원의 직무
            break;
        case 'EmployerAggregateRating': // 고용주 종합 평가 - 고용주에 대한 전체 평가
            break;
        case 'EmployerReview': // 고용주 리뷰 - 고용주에 대한 평가
            break;
        case 'EmploymentAgency': // 취업 알선소 - 구직/구인 중개 기관
            break;
        case 'EndorseAction': // 승인 액션 - 지지나 인정을 표현하는 행동
            break;
        case 'EndorsementRating': // 승인 평가 - 지지나 인정의 정도
            break;
        case 'Energy': // 에너지 - 동력이나 전력
            break;
        case 'EnergyConsumptionDetails': // 에너지 소비 세부사항 - 에너지 사용량 정보
            break;
        case 'EnergyEfficiencyEnumeration': // 에너지 효율 등급 - 에너지 효율성 분류
            break;
        case 'EnergyStarEnergyEfficiencyEnumeration': // 에너지스타 효율 등급 - 에너지스타 인증 효율성 분류
            break;
        case 'EngineSpecification': // 엔진 사양 - 엔진의 기술적 세부사항
            break;
        case 'EntertainmentBusiness': // 엔터테인먼트 사업 - 오락/여가 관련 사업
            break;
        case 'EntryPoint': // 진입점 - 시스템이나 서비스의 시작점
            break;
        case 'Enumeration': // 열거형 - 정의된 값들의 목록
            break;
        case 'Episode': // 에피소드 - 시리즈물의 한 회차
            break;
        case 'Event': // 이벤트 - 특정 시간과 장소에서 발생하는 행사
            break;
        case 'EventAttendanceModeEnumeration': // 이벤트 참석 방식 분류 - 행사 참여 형태 구분
            break;
        case 'EventReservation': // 이벤트 예약 - 행사 참석 예약
            break;
        case 'EventSeries': // 이벤트 시리즈 - 연속된 행사들
            break;
        case 'EventStatusType': // 이벤트 상태 유형 - 행사의 진행 상태
            break;
        case 'EventVenue': // 이벤트 장소 - 행사가 열리는 공간
            break;
        case 'ExchangeRateSpecification': // 환율 명세 - 통화 교환 비율 정보
            break;
        case 'ExerciseAction': // 운동 액션 - 신체 활동을 하는 행동
            break;
        case 'ExerciseGym': // 운동 체육관 - 운동 시설
            break;
        case 'ExercisePlan': // 운동 계획 - 운동 프로그램
            break;
        case 'ExhibitionEvent': // 전시 이벤트 - 전시회 행사
            break;
        case 'FAQPage': // FAQ 페이지 - 자주 묻는 질문 모음
            $result = egb_schema_autoload($type, $dom, $data);
            break;
        case 'FMRadioChannel': // FM 라디오 채널 - FM 방송국
            break;
        case 'FastFoodRestaurant': // 패스트푸드점 - 빠른 식사 제공 음식점
            break;
        case 'Festival': // 축제 - 문화 행사나 기념 행사
            break;
        case 'FilmAction': // 촬영 액션 - 영상을 찍는 행동
            break;
        case 'FinancialIncentive': // 재정적 인센티브 - 금전적 보상이나 혜택
            break;
        case 'FinancialProduct': // 금융 상품 - 금융 관련 상품
            break;
        case 'FinancialService': // 금융 서비스 - 금융 관련 서비스
            break;
        case 'FindAction': // 찾기 액션 - 검색하는 행동
            break;
        case 'FireStation': // 소방서 - 화재 진압 및 구조 기관
            break;
        case 'Flight': // 항공편 - 비행기 운항
            break;
        case 'FlightReservation': // 항공편 예약 - 비행기 좌석 예약
            break;
        case 'Float': // 부동소수점 - 소수점이 있는 숫자
            break;
        case 'FloorPlan': // 평면도 - 건물의 층별 설계도
            break;
        case 'Florist': // 꽃집 - 꽃과 식물 판매점
            break;
        case 'FollowAction': // 팔로우 액션 - 구독하거나 따르는 행동
            break;
        case 'FoodEstablishment': // 식당 - 음식을 제공하는 업소
            break;
        case 'FoodEstablishmentReservation': // 식당 예약 - 음식점 자리 예약
            break;
        case 'FoodEvent': // 음식 이벤트 - 음식 관련 행사
            break;
        case 'FoodService': // 음식 서비스 - 음식 제공 서비스
            break;
        case 'FulfillmentTypeEnumeration': // 이행 유형 분류 - 서비스 제공 방식 구분
            break;
        case 'FundingAgency': // 자금 지원 기관 - 재정 지원을 하는 조직
            break;
        case 'FundingScheme': // 자금 지원 계획 - 재정 지원 프로그램
            break;
        case 'FurnitureStore': // 가구점 - 가구 판매점
            break;
        case 'Game': // 게임 - 놀이나 경기
            break;
        case 'GameAvailabilityEnumeration': // 게임 이용 가능성 분류 - 게임 접근성 상태
            break;
        case 'GamePlayMode': // 게임 플레이 모드 - 게임 진행 방식
            break;
        case 'GameServer': // 게임 서버 - 게임 운영 서버
            break;
        case 'GameServerStatus': // 게임 서버 상태 - 게임 서버 운영 상태
            break;
        case 'GardenStore': // 정원용품점 - 정원 관련 물품 판매점
            break;
        case 'GasStation': // 주유소 - 연료 공급소
            break;
        case 'GatedResidenceCommunity': // 게이티드 커뮤니티 - 통제된 주거 단지
            break;
        case 'GenderType': // 성별 유형 - 성별 구분
            break;
        case 'Gene': // 유전자 - 유전 정보 단위
            break;
        case 'GeneralContractor': // 종합 건설업자 - 건설 총괄 책임자
            break;
        case 'GeoCircle': // 지리적 원 - 원형의 지리적 영역
            break;
        case 'GeoCoordinates': // 지리 좌표 - 위치의 좌표값
            break;
        case 'GeoShape': // 지리적 형태 - 지리적 영역의 모양
            break;
        case 'GeospatialGeometry': // 지리공간 기하학 - 공간적 형태와 관계
            break;
        case 'GiveAction': // 제공 액션 - 무언가를 주는 행동
            break;
        case 'GolfCourse': // 골프장 - 골프 경기장
            break;
        case 'GovernmentBenefitsType': // 정부 혜택 유형 - 정부 지원 종류
            break;
        case 'GovernmentBuilding': // 정부 건물 - 행정 기관 건물
            break;
        case 'GovernmentOffice': // 정부 사무소 - 행정 기관 사무실
            break;
        case 'GovernmentOrganization': // 정부 조직 - 행정 기관
            break;
        case 'GovernmentPermit': // 정부 허가 - 행정적 승인
            break;
        case 'GovernmentService': // 정부 서비스 - 행정 서비스
            break;
        case 'Grant': // 보조금 - 재정 지원금
            break;
        case 'GroceryStore': // 식료품점 - 식품 판매점
            break;
        case 'Guide': // 가이드 - 안내서나 지침
            break;
        case 'HVACBusiness': // 공조설비 사업 - 냉난방 환기 사업
            break;
        case 'Hackathon': // 해커톤 - 프로그래밍 경진대회
            break;
        case 'HairSalon': // 미용실 - 헤어 스타일링 업소
            break;
        case 'HardwareStore': // 철물점 - 공구와 자재 판매점
            break;
        case 'HealthAndBeautyBusiness': // 건강미용 사업 - 건강과 미용 관련 업소
            break;
        case 'HealthAspectEnumeration': // 건강 측면 분류 - 건강 관련 항목 구분
            break;
        case 'HealthClub': // 헬스클럽 - 운동 시설
            break;
        case 'HealthInsurancePlan': // 건강보험 계획 - 의료보험 상품
            break;
        case 'HealthPlanCostSharingSpecification': // 건강보험 비용분담 명세 - 의료보험 부담금 정보
            break;
        case 'HealthPlanFormulary': // 건강보험 처방집 - 보험 적용 약품 목록
            break;
        case 'HealthPlanNetwork': // 건강보험 네트워크 - 의료보험 제휴 망
            break;
        case 'HealthTopicContent': // 건강 주제 콘텐츠 - 건강 관련 정보
            break;
        case 'HighSchool': // 고등학교 - 중등 교육 기관
            break;
        case 'HinduTemple': // 힌두 사원 - 힌두교 예배 장소
            break;
        case 'HobbyShop': // 취미용품점 - 취미 관련 물품 판매점
            break;
        case 'HomeAndConstructionBusiness': // 주택건설 사업 - 주택 및 건설 관련 업체
            break;
        case 'HomeGoodsStore': // 가정용품점 - 가정용품 판매점
            break;
        case 'Hospital': // 병원 - 의료 기관
            break;
        case 'Hostel': // 호스텔 - 저가 숙박 시설
            break;
        case 'Hotel': // 호텔 - 숙박 시설
            break;
        case 'HotelRoom': // 호텔 객실 - 호텔의 방
            break;
        case 'House': // 주택 - 거주용 건물
            break;
        case 'HousePainter': // 집 도장공 - 건물 도색 전문가
            break;
        case 'HowTo': // 하우투 - 방법 안내
            break;
        case 'HowToDirection': // 하우투 방향 - 방법 안내의 방향
            break;
        case 'HowToItem': // 하우투 항목 - 방법 안내의 항목
            break;
        case 'HowToSection': // 하우투 섹션 - 방법 안내의 구역
            break;
        case 'HowToStep': // 하우투 단계 - 방법 안내의 단계
            break;
        case 'HowToSupply': // 하우투 준비물 - 방법 안내의 필요 물품
            break;
        case 'HowToTip': // 하우투 팁 - 방법 안내의 조언
            break;
        case 'HowToTool': // 하우투 도구 - 방법 안내의 필요 도구
            break;
        case 'HyperToc': // 하이퍼 목차 - 하이퍼링크된 목차
            break;
        case 'HyperTocEntry': // 하이퍼 목차 항목 - 하이퍼링크된 목차 항목
            break;
        case 'IPTCDigitalSourceEnumeration': // IPTC 디지털 소스 분류 - 디지털 미디어 출처 구분
            break;
        case 'IceCreamShop': // 아이스크림 가게 - 아이스크림 판매점
            break;
        case 'IgnoreAction': // 무시 액션 - 무시하는 행동
            break;
        case 'ImageGallery': // 이미지 갤러리 - 사진 모음
            break;
        case 'ImageObject': // 이미지 객체 - 이미지 파일
            break;
        case 'ImageObjectSnapshot': // 이미지 객체 스냅샷 - 이미지의 순간 캡처
            break;
        case 'ImagingTest': // 영상 검사 - 의료 영상 진단
            break;
        case 'IncentiveQualifiedExpenseType': // 인센티브 적격 비용 유형 - 보상 대상 비용 종류
            break;
        case 'IncentiveStatus': // 인센티브 상태 - 보상 진행 상태
            break;
        case 'IncentiveType': // 인센티브 유형 - 보상의 종류
            break;
        case 'IndividualPhysician': // 개인 의사 - 독립 의료인
            break;
        case 'IndividualProduct': // 개별 제품 - 단일 상품
            break;
        case 'InfectiousAgentClass': // 감염원 분류 - 감염성 물질의 종류
            break;
        case 'InfectiousDisease': // 감염성 질병 - 전염성 질환
            break;
        case 'InformAction': // 정보 제공 액션 - 정보를 알리는 행동
            break;
        case 'InsertAction': // 삽입 액션 - 추가하는 행동
            break;
        case 'InstallAction': // 설치 액션 - 설치하는 행동
            break;
        case 'InsuranceAgency': // 보험 대리점 - 보험 판매 중개점
            break;
        case 'Intangible': // 무형의 것 - 형체가 없는 것
            break;
        case 'Integer': // 정수 - 소수점이 없는 숫자
            break;
        case 'InteractAction': // 상호작용 액션 - 서로 영향을 주고받는 행동
            break;
        case 'InteractionCounter': // 상호작용 카운터 - 상호작용 횟수 측정기
            break;
        case 'InternetCafe': // 인터넷 카페 - 인터넷 이용 시설
            break;
        case 'InvestmentFund': // 투자 펀드 - 투자 자금
            break;
        case 'InvestmentOrDeposit': // 투자 또는 예금 - 자금 운용 방식
            break;
        case 'InviteAction': // 초대 액션 - 초대하는 행동
            break;
        case 'Invoice': // 청구서 - 대금 청구 문서
            break;
        case 'ItemAvailability': // 품목 가용성 - 상품 이용 가능 상태
            break;
        case 'ItemList': // 품목 목록 - 항목 리스트
            $result = egb_schema_autoload($type, $dom, $data);
            break;
        case 'ItemListOrderType': // 품목 목록 정렬 유형 - 항목 리스트 순서 방식
            break;
        case 'ItemPage': // 품목 페이지 - 상품 상세 페이지
            break;
        case 'JewelryStore': // 보석상 - 보석 판매점
            break;
        case 'JobPosting': // 구인 공고 - 일자리 모집 광고
            break;
        case 'JoinAction': // 가입 액션 - 참여하는 행동
            break;
        case 'Joint': // 관절 - 뼈와 뼈를 잇는 부위
            break;
        case 'LakeBodyOfWater': // 호수 - 담수 물줄기
            break;
        case 'Landform': // 지형 - 땅의 형태
            break;
        case 'LandmarksOrHistoricalBuildings': // 랜드마크 또는 역사적 건물 - 주요 명소나 역사 건축물
            break;
        case 'Language': // 언어 - 의사소통 수단
            break;
        case 'LearningResource': // 학습 자료 - 교육용 리소스
            break;
        case 'LeaveAction': // 떠나기 액션 - 떠나는 행동
            break;
        case 'LegalForceStatus': // 법적 효력 상태 - 법률적 유효성 상태
            break;
        case 'LegalService': // 법률 서비스 - 법률 관련 서비스
            break;
        case 'LegalValueLevel': // 법적 가치 수준 - 법률적 중요도
            break;
        case 'Legislation': // 법률 - 법령이나 규정
            break;
        case 'LegislationObject': // 법률 객체 - 법령 항목
            break;
        case 'LegislativeBuilding': // 입법부 건물 - 법률 제정 기관 건물
            break;
        case 'LendAction': // 대여 액션 - 빌려주는 행동
            break;
        case 'Library': // 도서관 - 도서 대여 시설
            break;
        case 'LibrarySystem': // 도서관 시스템 - 도서관 운영 체계
            break;
        case 'LifestyleModification': // 생활방식 수정 - 생활 습관 변경
            break;
        case 'Ligament': // 인대 - 뼈와 뼈를 연결하는 조직
            break;
        case 'LikeAction': // 좋아요 액션 - 긍정적 반응을 표시하는 행동
            break;
        case 'LinkRole': // 링크 역할 - 연결 기능
            break;
        case 'LiquorStore': // 주류판매점 - 술 판매점
            break;
        case 'ListItem': // 목록 항목 - 리스트의 항목
            break;
        case 'ListenAction': // 듣기 액션 - 청취하는 행동
            break;
        case 'LiteraryEvent': // 문학 행사 - 문학 관련 이벤트
            break;
        case 'LiveBlogPosting': // 실시간 블로그 포스팅 - 생중계 블로그 글
            break;
        case 'LoanOrCredit': // 대출 또는 신용 - 금전 차용
            break;
        case 'LocalBusiness': // 지역 사업체 - 지역 기반 업체
            $result = egb_schema_autoload($type, $dom, $data);
            break;
        case 'LocationFeatureSpecification': // 위치 특성 명세 - 장소의 특징 정보
            break;
        case 'Locksmith': // 자물쇠공 - 자물쇠 제작수리공
            break;
        case 'LodgingBusiness': // 숙박 사업 - 숙박 서비스업
            break;
        case 'LodgingReservation': // 숙박 예약 - 숙소 예약
            break;
        case 'LoseAction': // 분실 액션 - 잃어버리는 행동
            break;
        case 'LymphaticVessel': // 림프관 - 림프액 순환 통로
            break;
        case 'Manuscript': // 원고 - 손으로 쓴 문서
            break;
        case 'Map': // 지도 - 지리 정보 표현
            break;
        case 'MapCategoryType': // 지도 분류 유형 - 지도의 종류 구분
            break;
        case 'MarryAction': // 결혼 액션 - 혼인하는 행동
            break;
        case 'Mass': // 질량 - 물체의 양
            break;
        case 'MathSolver': // 수학 계산기 - 수학 문제 해결 도구
            break;
        case 'MaximumDoseSchedule': // 최대 투여 일정 - 약물 최대 복용 계획
            break;
        case 'MeasurementMethodEnum': // 측정 방법 열거 - 측정 방식 구분
            break;
        case 'MeasurementTypeEnumeration': // 측정 유형 분류 - 측정 종류 구분
            break;
        case 'MediaEnumeration': // 미디어 분류 - 매체 종류 구분
            break;
        case 'MediaGallery': // 미디어 갤러리 - 멀티미디어 모음
            break;
        case 'MediaManipulationRatingEnumeration': // 미디어 조작 등급 분류 - 미디어 변형 정도 구분
            break;
        case 'MediaObject': // 미디어 객체 - 멀티미디어 파일
            break;
        case 'MediaReview': // 미디어 리뷰 - 매체 평가
            break;
        case 'MediaReviewItem': // 미디어 리뷰 항목 - 매체 평가 항목
            break;
        case 'MediaSubscription': // 미디어 구독 - 매체 이용권
            break;
        case 'MedicalAudience': // 의료 청중 - 의료 정보 수용자
            break;
        case 'MedicalAudienceType': // 의료 청중 유형 - 의료 정보 수용자 종류
            break;
        case 'MedicalBusiness': // 의료 사업 - 의료 관련 업체
            break;
        case 'MedicalCause': // 의학적 원인 - 질병이나 증상의 발생 요인
            break;
        case 'MedicalClinic': // 의료 클리닉 - 외래 진료 시설
            break;
        case 'MedicalCode': // 의료 코드 - 의학 분류 체계
            break;
        case 'MedicalCondition': // 의학적 상태 - 질병이나 건강 상태
            break;
        case 'MedicalConditionStage': // 의학적 상태 단계 - 질병 진행 단계
            break;
        case 'MedicalContraindication': // 의학적 금기 - 치료나 약물 사용 제한 사항
            break;
        case 'MedicalDevice': // 의료 기기 - 의학적 목적의 장비
            break;
        case 'MedicalDevicePurpose': // 의료 기기 용도 - 의료 기기의 사용 목적
            break;
        case 'MedicalEntity': // 의료 개체 - 의학 관련 항목
            break;
        case 'MedicalEnumeration': // 의료 열거 - 의학 관련 분류
            break;
        case 'MedicalEvidenceLevel': // 의학적 증거 수준 - 의학적 연구의 신뢰도 등급
            break;
        case 'MedicalGuideline': // 의료 지침 - 진료 및 치료 기준
            break;
        case 'MedicalGuidelineContraindication': // 의료 지침 금기 - 치료 지침상 제한 사항
            break;
        case 'MedicalGuidelineRecommendation': // 의료 지침 권장사항 - 치료 지침상 권고 사항
            break;
        case 'MedicalImagingTechnique': // 의료 영상 기법 - 의학적 영상 촬영 방식
            break;
        case 'MedicalIndication': // 의학적 적응증 - 치료나 약물 사용이 필요한 상태
            break;
        case 'MedicalIntangible': // 의료 무형물 - 비물질적 의료 요소
            break;
        case 'MedicalObservationalStudy': // 의학적 관찰 연구 - 의학 관찰 조사
            break;
        case 'MedicalObservationalStudyDesign': // 의학적 관찰 연구 설계 - 관찰 연구 방법론
            break;
        case 'MedicalOrganization': // 의료 기관 - 의료 서비스 제공 조직
            break;
        case 'MedicalProcedure': // 의료 시술 - 치료 및 수술 절차
            break;
        case 'MedicalProcedureType': // 의료 시술 유형 - 치료 절차의 종류
            break;
        case 'MedicalRiskCalculator': // 의료 위험 계산기 - 건강 위험도 평가 도구
            break;
        case 'MedicalRiskEstimator': // 의료 위험 추정기 - 건강 위험 예측 도구
            break;
        case 'MedicalRiskFactor': // 의료 위험 요인 - 건강상 위험 요소
            break;
        case 'MedicalRiskScore': // 의료 위험 점수 - 건강 위험도 평가 점수
            break;
        case 'MedicalScholarlyArticle': // 의학 학술 논문 - 의학 연구 논문
            break;
        case 'MedicalSign': // 의학적 징후 - 질병의 객관적 증상
            break;
        case 'MedicalSignOrSymptom': // 의학적 징후나 증상 - 질병의 징후와 증상
            break;
        case 'MedicalSpecialty': // 의료 전문분야 - 의학 전문 영역
            break;
        case 'MedicalStudy': // 의학 연구 - 의학적 조사 연구
            break;
        case 'MedicalStudyStatus': // 의학 연구 상태 - 연구 진행 단계
            break;
        case 'MedicalSymptom': // 의학적 증상 - 질병의 주관적 증상
            break;
        case 'MedicalTest': // 의료 검사 - 진단 검사
            break;
        case 'MedicalTestPanel': // 의료 검사 패널 - 검사 항목 묶음
            break;
        case 'MedicalTherapy': // 의료 치료 - 질병 치료 방법
            break;
        case 'MedicalTrial': // 의료 시험 - 임상 시험
            break;
        case 'MedicalTrialDesign': // 의료 시험 설계 - 임상 시험 방법론
            break;
        case 'MedicalWebPage': // 의료 웹페이지 - 의학 정보 웹페이지
            break;
        case 'MedicineSystem': // 의학 체계 - 의료 체계 분류
            break;
        case 'MeetingRoom': // 회의실 - 모임 공간
            break;
        case 'MemberProgram': // 회원 프로그램 - 멤버십 제도
            break;
        case 'MemberProgramTier': // 회원 프로그램 등급 - 멤버십 레벨
            break;
        case 'MensClothingStore': // 남성복 매장 - 남성 의류 판매점
            break;
        case 'Menu': // 메뉴 - 음식 목록
            break;
        case 'MenuItem': // 메뉴 항목 - 개별 메뉴 품목
            break;
        case 'MenuSection': // 메뉴 섹션 - 메뉴 분류
            break;
        case 'MerchantReturnEnumeration': // 판매자 반품 분류 - 반품 정책 유형
            break;
        case 'MerchantReturnPolicy': // 판매자 반품 정책 - 반품 규정
            break;
        case 'MerchantReturnPolicySeasonalOverride': // 판매자 반품 정책 계절성 예외 - 시즌별 반품 규정
            break;
        case 'Message': // 메시지 - 전달 내용
            break;
        case 'MiddleSchool': // 중학교 - 중등 교육 기관
            break;
        case 'MobileApplication': // 모바일 애플리케이션 - 스마트폰 앱
            break;
        case 'MobilePhoneStore': // 휴대폰 매장 - 모바일 기기 판매점
            break;
        case 'MolecularEntity': // 분자 개체 - 분자 단위 물질
            break;
        case 'MonetaryAmount': // 금액 - 화폐 가치
            break;
        case 'MonetaryAmountDistribution': // 금액 분포 - 화폐 가치 분포
            break;
        case 'MonetaryGrant': // 금전 보조금 - 재정 지원금
            break;
        case 'MoneyTransfer': // 송금 - 자금 이체
            break;
        case 'MortgageLoan': // 주택담보대출 - 부동산 담보 대출
            break;
        case 'Mosque': // 모스크 - 이슬람 사원
            break;
        case 'Motel': // 모텔 - 자동차 여행자용 숙박시설
            break;
        case 'Motorcycle': // 오토바이 - 이륜 자동차
            break;
        case 'MotorcycleDealer': // 오토바이 대리점 - 이륜차 판매점
            break;
        case 'MotorcycleRepair': // 오토바이 수리 - 이륜차 정비
            break;
        case 'MotorizedBicycle': // 동력자전거 - 모터 달린 자전거
            break;
        case 'Mountain': // 산 - 높은 지형
            break;
        case 'MoveAction': // 이동 액션 - 위치 변경 행동
            break;
        case 'Movie': // 영화 - 동영상 작품
            break;
        case 'MovieClip': // 영화 클립 - 영화 일부분
            break;
        case 'MovieRentalStore': // 영화 대여점 - 비디오 대여 상점
            break;
        case 'MovieSeries': // 영화 시리즈 - 연작 영화
            break;
        case 'MovieTheater': // 영화관 - 영화 상영관
            break;
        case 'MovingCompany': // 이사 회사 - 운송 서비스업체
            break;
        case 'Muscle': // 근육 - 신체 근육 조직
            break;
        case 'Museum': // 박물관 - 전시 문화 시설
            break;
        case 'MusicAlbum': // 음악 앨범 - 음반
            break;
        case 'MusicAlbumProductionType': // 음악 앨범 제작 유형 - 앨범 제작 방식
            break;
        case 'MusicAlbumReleaseType': // 음악 앨범 발매 유형 - 앨범 출시 형태
            break;
        case 'MusicComposition': // 음악 작곡 - 곡 창작
            break;
        case 'MusicEvent': // 음악 행사 - 음악 관련 이벤트
            break;
        case 'MusicGroup': // 음악 그룹 - 음악 단체
            break;
        case 'MusicPlaylist': // 음악 재생목록 - 곡 모음
            break;
        case 'MusicRecording': // 음악 녹음 - 녹음된 음악
            break;
        case 'MusicRelease': // 음악 발매 - 음반 출시
            break;
        case 'MusicReleaseFormatType': // 음악 발매 형식 유형 - 음반 출시 형태
            break;
        case 'MusicStore': // 음악 상점 - 음반 판매점
            break;
        case 'MusicVenue': // 음악 공연장 - 음악 공연 시설
            break;
        case 'MusicVideoObject': // 뮤직비디오 객체 - 음악 영상
            break;
        case 'NGO': // 비정부기구 - 민간 단체
            break;
        case 'NLNonprofitType': // 네덜란드 비영리 유형 - 네덜란드 비영리 단체 분류
            break;
        case 'NailSalon': // 네일샵 - 손톱 관리실
            break;
        case 'Nerve': // 신경 - 신경 조직
            break;
        case 'NewsArticle': // 뉴스 기사 - 시사 보도문
            break;
        case 'NewsMediaOrganization': // 뉴스 미디어 조직 - 언론사
            break;
        case 'Newspaper': // 신문 - 정기 간행물
            break;
        case 'NightClub': // 나이트클럽 - 야간 유흥시설
            break;
        case 'NonprofitType': // 비영리 유형 - 비영리 단체 분류
            break;
        case 'Notary': // 공증인 - 법적 공증인
            break;
        case 'NoteDigitalDocument': // 디지털 메모 문서 - 전자 노트
            break;
        case 'Number': // 숫자 - 수치
            break;
        case 'NutritionInformation': // 영양 정보 - 영양 성분 정보
            break;
        case 'Observation': // 관찰 - 관찰 결과
            break;
        case 'Occupation': // 직업 - 직종
            break;
        case 'OccupationalExperienceRequirements': // 직업 경험 요구사항 - 경력 조건
            break;
        case 'OccupationalTherapy': // 작업 치료 - 재활 치료
            break;
        case 'OceanBodyOfWater': // 해양 - 바다
            break;
        case 'Offer': // 제안 - 상품이나 서비스 제공
            break;
        case 'OfferCatalog': // 제안 카탈로그 - 상품 목록
            $result = egb_schema_autoload($type, $dom, $data);
            break;
        case 'OfferForLease': // 임대 제안 - 임대 상품
            break;
        case 'OfferForPurchase': // 구매 제안 - 판매 상품
            break;
        case 'OfferItemCondition': // 제안 상품 상태 - 상품 컨디션
            break;
        case 'OfferShippingDetails': // 제안 배송 상세 - 배송 정보
            break;
        case 'OfficeEquipmentStore': // 사무용품점 - 사무기기 판매점
            break;
        case 'OnDemandEvent': // 주문형 이벤트 - 요청시 제공 행사
            break;
        case 'OnlineBusiness': // 온라인 사업 - 인터넷 비즈니스
            break;
        case 'OnlineStore': // 온라인 상점 - 인터넷 쇼핑몰
            break;
        case 'OpeningHoursSpecification': // 영업시간 명세 - 운영 시간 정보
            break;
        case 'OpinionNewsArticle': // 의견 뉴스 기사 - 논평 기사
            break;
        case 'Optician': // 안경사 - 안경 제작 전문가
            break;
        case 'Order': // 주문 - 상품 구매 요청
            break;
        case 'OrderAction': // 주문 액션 - 주문 행위
            break;
        case 'OrderItem': // 주문 항목 - 주문 상품
            break;
        case 'OrderStatus': // 주문 상태 - 주문 진행 상태
            break;
        case 'Organization': // 조직 - 단체
            $result = egb_schema_autoload($type, $dom, $data);
            break;
        case 'OrganizationRole': // 조직 역할 - 조직 내 직책
            break;
        case 'OrganizeAction': // 조직화 액션 - 정리 행위
            break;
        case 'OutletStore': // 아울렛 매장 - 할인 판매점
            break;
        case 'OwnershipInfo': // 소유권 정보 - 소유 관계 정보
            break;
        case 'PaintAction': // 그리기 액션 - 채색 행위
            break;
        case 'Painting': // 회화 - 그림
            break;
        case 'PalliativeProcedure': // 완화 치료 - 증상 완화 처치
            break;
        case 'ParcelDelivery': // 소포 배송 - 택배 서비스
            break;
        case 'ParentAudience': // 학부모 청중 - 학부모 대상
            break;
        case 'Park': // 공원 - 휴식 공간
            break;
        case 'ParkingFacility': // 주차 시설 - 주차장
            break;
        case 'PathologyTest': // 병리 검사 - 질병 진단 검사
            break;
        case 'Patient': // 환자 - 진료 대상자
            break;
        case 'PawnShop': // 전당포 - 담보 대출점
            break;
        case 'PayAction': // 지불 액션 - 결제 행위
            break;
        case 'PaymentCard': // 결제 카드 - 지불 수단 카드
            break;
        case 'PaymentChargeSpecification': // 결제 요금 명세 - 지불 금액 정보
            break;
        case 'PaymentMethod': // 결제 방법 - 지불 수단
            break;
        case 'PaymentMethodType': // 결제 방법 유형 - 지불 수단 종류
            break;
        case 'PaymentService': // 결제 서비스 - 지불 서비스
            break;
        case 'PaymentStatusType': // 결제 상태 유형 - 지불 상태 분류
            break;
        case 'PeopleAudience': // 일반 청중 - 대중 대상
            break;
        case 'PerformAction': // 수행 액션 - 실행 행위
            break;
        case 'PerformanceRole': // 공연 역할 - 공연자 역할
            break;
        case 'PerformingArtsTheater': // 공연 예술 극장 - 공연장
            break;
        case 'PerformingGroup': // 공연 그룹 - 공연 단체
            break;
        case 'Periodical': // 정기 간행물 - 주기적 출판물
            break;
        case 'Permit': // 허가증 - 인허가 문서
            break;
        case 'Person': // 사람 - 개인
            $result = egb_schema_autoload($type, $dom, $data);
            break;
        case 'PetStore': // 애완동물 상점 - 반려동물 용품점
            break;
        case 'Pharmacy': // 약국 - 의약품 판매점
            break;
        case 'Photograph': // 사진 - 촬영 이미지
            break;
        case 'PhotographAction': // 사진 촬영 액션 - 촬영 행위
            break;
        case 'PhysicalActivity': // 신체 활동 - 운동
            break;
        case 'PhysicalActivityCategory': // 신체 활동 분류 - 운동 종류
            break;
        case 'PhysicalExam': // 신체 검사 - 건강 검진
            break;
        case 'PhysicalTherapy': // 물리 치료 - 재활 운동
            break;
        case 'Physician': // 의사 - 의료인
            break;
        case 'PhysiciansOffice': // 의사 진료실 - 개인 병원
            break;
        case 'Place': // 장소 - 위치
            break;
        case 'PlaceOfWorship': // 예배 장소 - 종교 시설
            break;
        case 'PlanAction': // 계획 액션 - 계획 수립
            break;
        case 'Play': // 연극 - 무대 공연
            break;
        case 'PlayAction': // 놀이 액션 - 놀이 행위
            break;
        case 'PlayGameAction': // 게임 플레이 액션 - 게임 행위
            break;
        case 'Playground': // 놀이터 - 어린이 놀이 시설
            break;
        case 'Plumber': // 배관공 - 수도 설비공
            break;
        case 'PodcastEpisode': // 팟캐스트 에피소드 - 방송 회차
            break;
        case 'PodcastSeason': // 팟캐스트 시즌 - 방송 시즌
            break;
        case 'PodcastSeries': // 팟캐스트 시리즈 - 방송 시리즈
            break;
        case 'PoliceStation': // 경찰서 - 치안 시설
            break;
        case 'PoliticalParty': // 정당 - 정치 단체
            break;
        case 'Pond': // 연못 - 작은 호수
            break;
        case 'PostOffice': // 우체국 - 우편 시설
            break;
        case 'PostalAddress': // 우편 주소 - 배송지 정보
            break;
        case 'PostalCodeRangeSpecification': // 우편번호 범위 명세 - 우편번호 구간
            break;
        case 'Poster': // 포스터 - 광고 게시물
            break;
        case 'PreOrderAction': // 사전 주문 액션 - 선주문 행위
            break;
        case 'PrependAction': // 앞부분 추가 액션 - 앞쪽 삽입
            break;
        case 'Preschool': // 유치원 - 취학전 교육기관
            break;
        case 'PresentationDigitalDocument': // 프레젠테이션 디지털 문서 - 발표 자료
            break;
        case 'PreventionIndication': // 예방 적응증 - 예방 필요 상태
            break;
        case 'PriceComponentTypeEnumeration': // 가격 구성 요소 유형 분류 - 가격 요소 종류
            break;
        case 'PriceSpecification': // 가격 명세 - 가격 정보
            $result = egb_schema_autoload($type, $dom, $data);
            break;
        case 'PriceTypeEnumeration': // 가격 유형 분류 - 가격 종류
            break;
        case 'Product': // 제품 - 상품
            break;
        case 'ProductCollection': // 제품 컬렉션 - 상품 모음
            break;
        case 'ProductGroup': // 제품 그룹 - 상품 분류
            break;
        case 'ProductModel': // 제품 모델 - 상품 모델
            break;
        case 'ProfessionalService': // 전문 서비스 - 전문가 서비스
            break;
        case 'ProfilePage': // 프로필 페이지 - 소개 페이지
            break;
        case 'ProgramMembership': // 프로그램 멤버십 - 회원 제도
            break;
        case 'Project': // 프로젝트 - 사업 계획
            break;
        case 'PronounceableText': // 발음 가능 텍스트 - 발음 표기
            break;
        case 'Property': // 속성 - 특성
            break;
        case 'PropertyValue': // 속성 값 - 특성 값
            break;
        case 'PropertyValueSpecification': // 속성 값 명세 - 특성 값 정보
            break;
        case 'Protein': // 단백질 - 단백질 물질
            break;
        case 'PsychologicalTreatment': // 심리 치료 - 정신 치료
            break;
        case 'PublicSwimmingPool': // 공공 수영장 - 공공 수영 시설
            break;
        case 'PublicToilet': // 공중 화장실 - 공공 화장실
            break;
        case 'PublicationEvent': // 출판 이벤트 - 발행 행사
            break;
        case 'PublicationIssue': // 출판물 호 - 간행물 호수
            break;
        case 'PublicationVolume': // 출판물 권 - 간행물 권수
            break;
        case 'PurchaseType': // 구매 유형 - 구매 방식
            break;
        case 'QAPage': // 질문답변 페이지 - Q&A 페이지
            break;
        case 'QualitativeValue': // 정성적 값 - 질적 가치
            break;
        case 'QuantitativeValue': // 정량적 값 - 양적 수치
            break;
        case 'QuantitativeValueDistribution': // 정량적 값 분포 - 수치 분포
            break;
        case 'Quantity': // 수량 - 양
            break;
        case 'Question': // 질문 - 의문
            break;
        case 'Quiz': // 퀴즈 - 문제
            break;
        case 'Quotation': // 인용구 - 인용문
            break;
        case 'QuoteAction': // 인용 액션 - 인용 행위
            $result = egb_schema_autoload($type, $dom, $data);
            break;
        case 'RVPark': // RV파크 - 캠핑카 주차장
            break;
        case 'RadiationTherapy': // 방사선 치료 - 방사선 요법
            break;
        case 'RadioBroadcastService': // 라디오 방송 서비스 - 라디오 방송
            break;
        case 'RadioChannel': // 라디오 채널 - 라디오 방송국
            break;
        case 'RadioClip': // 라디오 클립 - 라디오 방송 일부
            break;
        case 'RadioEpisode': // 라디오 에피소드 - 라디오 방송 회차
            break;
        case 'RadioSeason': // 라디오 시즌 - 라디오 방송 시즌
            break;
        case 'RadioSeries': // 라디오 시리즈 - 라디오 방송 시리즈
            break;
        case 'RadioStation': // 라디오 방송국 - 라디오 송출 시설
            break;
        case 'Rating': // 평가 - 등급
            break;
        case 'ReactAction': // 반응 액션 - 반응 행위
            break;
        case 'ReadAction': // 읽기 액션 - 독서 행위
            break;
        case 'RealEstateAgent': // 부동산 중개인 - 부동산 거래 중개사
            break;
        case 'RealEstateListing': // 부동산 매물 - 부동산 거래 물건
            break;
        case 'ReceiveAction': // 수신 액션 - 수령 행위
            break;
        case 'Recipe': // 레시피 - 조리법
            break;
        case 'Recommendation': // 추천 - 권장사항
            break;
        case 'RecommendedDoseSchedule': // 권장 투여 일정 - 약물 복용 권장 계획
            break;
        case 'RecyclingCenter': // 재활용 센터 - 재활용품 수거 시설
            break;
        case 'RefundTypeEnumeration': // 환불 유형 분류 - 환불 방식 종류
            break;
        case 'RegisterAction': // 등록 액션 - 등록 행위
            break;
        case 'RejectAction': // 거절 액션 - 거부 행위
            break;
        case 'RentAction': // 임대 액션 - 대여 행위
            break;
        case 'RentalCarReservation': // 렌터카 예약 - 차량 대여 예약
            break;
        case 'RepaymentSpecification': // 상환 명세 - 상환 조건
            break;
        case 'ReplaceAction': // 교체 액션 - 대체 행위
            break;
        case 'ReplyAction': // 답장 액션 - 응답 행위
            break;
        case 'Report': // 보고서 - 보고 문서
            break;
        case 'ReportageNewsArticle': // 르포 뉴스 기사 - 현장 취재 기사
            break;
        case 'ReportedDoseSchedule': // 보고된 투여 일정 - 약물 복용 실제 기록
            break;
        case 'ResearchOrganization': // 연구 기관 - 연구 수행 조직
            break;
        case 'ResearchProject': // 연구 프로젝트 - 연구 과제
            break;
        case 'Researcher': // 연구원 - 연구 수행자
            break;
        case 'Reservation': // 예약 - 사전 등록
            break;
        case 'ReservationPackage': // 예약 패키지 - 예약 상품 묶음
            break;
        case 'ReservationStatusType': // 예약 상태 유형 - 예약 진행 상황 종류
            break;
        case 'ReserveAction': // 예약 액션 - 예약 행위
            break;
        case 'Reservoir': // 저수지 - 물 저장 시설
            break;
        case 'Residence': // 주거지 - 거주 공간
            break;
        case 'Resort': // 리조트 - 휴양 시설
            break;
        case 'Restaurant': // 레스토랑 - 음식점
            break;
        case 'RestrictedDiet': // 제한 식단 - 식이 제한
            break;
        case 'ResumeAction': // 재개 액션 - 다시 시작 행위
            break;
        case 'ReturnAction': // 반환 액션 - 되돌려주기 행위
            break;
        case 'ReturnFeesEnumeration': // 반품 수수료 분류 - 반품 비용 종류
            break;
        case 'ReturnLabelSourceEnumeration': // 반품 라벨 출처 분류 - 반품 표시 발행처 종류
            break;
        case 'ReturnMethodEnumeration': // 반품 방법 분류 - 반품 처리 방식 종류
            break;
        case 'Review': // 리뷰 - 평가 내용
            break;
        case 'ReviewAction': // 리뷰 액션 - 평가 행위
            break;
        case 'ReviewNewsArticle': // 리뷰 뉴스 기사 - 평론 기사
            break;
        case 'RiverBodyOfWater': // 강 수계 - 하천 수역
            break;
        case 'Role': // 역할 - 담당 업무
            break;
        case 'RoofingContractor': // 지붕 시공업자 - 지붕 공사 전문가
            break;
        case 'Room': // 방 - 실내 공간
            break;
        case 'RsvpAction': // 참석 회신 액션 - 참가 여부 응답 행위
            break;
        case 'RsvpResponseType': // 참석 회신 응답 유형 - 참가 여부 답변 종류
            break;
        case 'SaleEvent': // 판매 이벤트 - 할인 행사
            break;
        case 'SatiricalArticle': // 풍자 기사 - 비평적 해학 글
            break;
        case 'Schedule': // 일정 - 시간 계획
            break;
        case 'ScheduleAction': // 일정 액션 - 일정 잡기 행위
            break;
        case 'ScholarlyArticle': // 학술 기사 - 연구 논문
            break;
        case 'School': // 학교 - 교육 기관
            break;
        case 'SchoolDistrict': // 학군 - 교육 행정구역
            break;
        case 'ScreeningEvent': // 상영 이벤트 - 영상물 상영회
            break;
        case 'Sculpture': // 조각 - 입체 예술품
            break;
        case 'SeaBodyOfWater': // 해양 수계 - 바다 수역
            break;
        case 'SearchAction': // 검색 액션 - 찾기 행위
            break;
        case 'SearchRescueOrganization': // 수색구조 조직 - 구조대
            break;
        case 'SearchResultsPage': // 검색결과 페이지 - 검색 결과 화면
            break;
        case 'Season': // 시즌 - 계절성 기간
            break;
        case 'Seat': // 좌석 - 착석 공간
            break;
        case 'SeekToAction': // 탐색 액션 - 찾아가기 행위
            break;
        case 'SelfStorage': // 셀프 스토리지 - 개인 창고
            break;
        case 'SellAction': // 판매 액션 - 팔기 행위
            break;
        case 'SendAction': // 전송 액션 - 보내기 행위
            break;
        case 'Series': // 시리즈 - 연작물
            break;
        case 'Service': // 서비스 - 용역
            $result = egb_schema_autoload($type, $dom, $data);
            break;
        case 'ServiceChannel': // 서비스 채널 - 서비스 제공 경로
            break;
        case 'ServicePeriod': // 서비스 기간 - 서비스 제공 시간
            break;
        case 'ShareAction': // 공유 액션 - 나누기 행위
            break;
        case 'SheetMusic': // 악보 - 음악 기보
            break;
        case 'ShippingConditions': // 배송 조건 - 운송 약관
            break;
        case 'ShippingDeliveryTime': // 배송 소요 시간 - 운송 기간
            break;
        case 'ShippingRateSettings': // 배송료 설정 - 운송비 책정
            break;
        case 'ShippingService': // 배송 서비스 - 운송 용역
            break;
        case 'ShoeStore': // 신발 가게 - 신발 판매점
            break;
        case 'ShoppingCenter': // 쇼핑 센터 - 복합 상가
            break;
        case 'ShortStory': // 단편 소설 - 짧은 이야기
            break;
        case 'SingleFamilyResidence': // 단독 주택 - 개인 주거
            break;
        case 'SiteNavigationElement': // 사이트 내비게이션 요소 - 웹사이트 메뉴
            break;
        case 'SizeGroupEnumeration': // 크기 그룹 분류 - 사이즈 구분 종류
            break;
        case 'SizeSpecification': // 크기 명세 - 치수 정보
            break;
        case 'SizeSystemEnumeration': // 치수 체계 분류 - 사이즈 기준 종류
            break;
        case 'SkiResort': // 스키 리조트 - 스키장
            break;
        case 'SocialEvent': // 사교 이벤트 - 친목 행사
            break;
        case 'SocialMediaPosting': // 소셜 미디어 게시물 - SNS 글
            break;
        case 'SoftwareApplication': // 소프트웨어 응용프로그램 - 컴퓨터 프로그램
            break;
        case 'SoftwareSourceCode': // 소프트웨어 소스코드 - 프로그램 원본
            break;
        case 'SolveMathAction': // 수학 문제 풀이 액션 - 수학 계산 행위
            break;
        case 'SomeProducts': // 일부 제품 - 특정 상품군
            break;
        case 'SpeakableSpecification': // 음성 인식 명세 - 음성 처리 정보
            break;
        case 'SpecialAnnouncement': // 특별 공지 - 중요 안내
            break;
        case 'Specialty': // 전문 분야 - 특화 영역
            break;
        case 'SportingGoodsStore': // 스포츠용품점 - 운동 기구 판매점
            break;
        case 'SportsActivityLocation': // 스포츠 활동 장소 - 운동 시설
            break;
        case 'SportsClub': // 스포츠 클럽 - 운동 동호회
            break;
        case 'SportsEvent': // 스포츠 이벤트 - 체육 행사
            break;
        case 'SportsOrganization': // 스포츠 조직 - 체육 단체
            break;
        case 'SportsTeam': // 스포츠 팀 - 운동 선수단
            break;
        case 'SpreadsheetDigitalDocument': // 스프레드시트 디지털 문서 - 전자 표 문서
            break;
        case 'StadiumOrArena': // 경기장 - 대형 운동장
            break;
        case 'State': // 주 - 행정구역
            break;
        case 'Statement': // 성명서 - 공식 발표문
            break;
        case 'StatisticalPopulation': // 통계 모집단 - 통계 대상군
            break;
        case 'StatisticalVariable': // 통계 변수 - 통계 측정값
            break;
        case 'StatusEnumeration': // 상태 분류 - 현황 종류
            break;
        case 'SteeringPositionValue': // 운전석 위치값 - 핸들 방향
            break;
        case 'Store': // 상점 - 판매점
            break;
        case 'StructuredValue': // 구조화된 값 - 체계적 데이터
            break;
        case 'SubscribeAction': // 구독 액션 - 정기 신청 행위
            break;
        case 'Substance': // 물질 - 재료
            break;
        case 'SubwayStation': // 지하철역 - 전철역
            break;
        case 'Suite': // 스위트룸 - 고급 객실
            break;
        case 'SuperficialAnatomy': // 표면 해부학 - 외부 신체 구조
            break;
        case 'SurgicalProcedure': // 수술 절차 - 외과 시술
            break;
        case 'SuspendAction': // 중단 액션 - 일시 정지 행위
            break;
        case 'Syllabus': // 강의 계획서 - 수업 일정표
            break;
        case 'Synagogue': // 시나고그 - 유대교 예배당
            break;
        case 'TVClip': // TV 클립 - 방송 영상 일부
            break;
        case 'TVEpisode': // TV 에피소드 - 방송 회차
            break;
        case 'TVSeason': // TV 시즌 - 방송 시즌
            break;
        case 'TVSeries': // TV 시리즈 - 방송 연작
            break;
        case 'Table': // 테이블 - 표
            break;
        case 'TakeAction': // 취하기 액션 - 가져가기 행위
            break;
        case 'TattooParlor': // 타투 가게 - 문신 시술소
            break;
        case 'Taxi': // 택시 - 개인 운송 차량
            break;
        case 'TaxiReservation': // 택시 예약 - 택시 호출
            break;
        case 'TaxiService': // 택시 서비스 - 택시 운송 용역
            break;
        case 'TaxiStand': // 택시 승강장 - 택시 정류장
            break;
        case 'Taxon': // 분류군 - 생물 분류
            break;
        case 'TechArticle': // 기술 기사 - 기술 문서
            break;
        case 'TelevisionChannel': // 텔레비전 채널 - TV 방송 채널
            break;
        case 'TelevisionStation': // 텔레비전 방송국 - TV 송출 시설
            break;
        case 'TennisComplex': // 테니스 단지 - 테니스장
            break;
        case 'Text': // 텍스트 - 문자
            break;
        case 'TextDigitalDocument': // 텍스트 디지털 문서 - 전자 문서
            break;
        case 'TextObject': // 텍스트 객체 - 문자 데이터
            break;
        case 'TheaterEvent': // 극장 이벤트 - 공연 행사
            break;
        case 'TheaterGroup': // 극단 - 연극 단체
            break;
        case 'TherapeuticProcedure': // 치료 절차 - 치료 과정
            break;
        case 'Thesis': // 논문 - 학위 논문
            break;
        case 'Thing': // 사물 - 물건
            break;
        case 'Ticket': // 티켓 - 입장권
            break;
        case 'TieAction': // 묶기 액션 - 연결 행위
            break;
        case 'TierBenefitEnumeration': // 등급 혜택 분류 - 회원 특전 종류
            break;
        case 'Time': // 시간 - 때
            break;
        case 'TipAction': // 팁 액션 - 봉사료 지급 행위
            break;
        case 'TireShop': // 타이어 가게 - 타이어 판매점
            break;
        case 'TouristAttraction': // 관광 명소 - 관광지
            break;
        case 'TouristDestination': // 관광 목적지 - 여행지
            break;
        case 'TouristInformationCenter': // 관광 안내소 - 여행 정보 센터
            break;
        case 'TouristTrip': // 관광 여행 - 관광 일정
            break;
        case 'ToyStore': // 장난감 가게 - 완구점
            break;
        case 'TrackAction': // 추적 액션 - 경로 확인 행위
            break;
        case 'TradeAction': // 거래 액션 - 매매 행위
            break;
        case 'TrainReservation': // 기차 예약 - 열차 승차권 예매
            break;
        case 'TrainStation': // 기차역 - 철도역
            break;
        case 'TrainTrip': // 기차 여행 - 열차 여정
            break;
        case 'TransferAction': // 이전 액션 - 옮기기 행위
            break;
        case 'TravelAction': // 여행 액션 - 이동 행위
            break;
        case 'TravelAgency': // 여행사 - 관광 대행사
            break;
        case 'TreatmentIndication': // 치료 적응증 - 치료 대상 증상
            break;
        case 'Trip': // 여행 - 여정
            break;
        case 'TypeAndQuantityNode': // 유형 및 수량 노드 - 종류와 양 정보
            break;
        case 'UKNonprofitType': // 영국 비영리 유형 - 영국 공익 단체 종류
            break;
        case 'URL': // URL - 웹 주소
            break;
        case 'USNonprofitType': // 미국 비영리 유형 - 미국 공익 단체 종류
            break;
        case 'UnRegisterAction': // 등록 취소 액션 - 해지 행위
            break;
        case 'UnitPriceSpecification': // 단가 명세 - 개별 가격 정보
            break;
        case 'UpdateAction': // 갱신 액션 - 업데이트 행위
            break;
        case 'UseAction': // 사용 액션 - 이용 행위
            break;
        case 'UserBlocks': // 사용자 차단 - 이용자 제한
            break;
        case 'UserCheckins': // 사용자 체크인 - 이용자 방문
            break;
        case 'UserComments': // 사용자 댓글 - 이용자 의견
            break;
        case 'UserDownloads': // 사용자 다운로드 - 이용자 내려받기
            break;
        case 'UserInteraction': // 사용자 상호작용 - 이용자 활동
            break;
        case 'UserLikes': // 사용자 좋아요 - 이용자 선호
            break;
        case 'UserPageVisits': // 사용자 페이지 방문 - 이용자 접속
            break;
        case 'UserPlays': // 사용자 재생 - 이용자 플레이
            break;
        case 'UserPlusOnes': // 사용자 플러스원 - 이용자 추천
            break;
        case 'UserReview': // 사용자 리뷰 - 이용자 평가
            break;
        case 'UserTweets': // 사용자 트윗 - 이용자 트위터글
            break;
        case 'VacationRental': // 휴가용 임대 - 휴양지 숙소
            break;
        case 'Vehicle': // 차량 - 운송 수단
            break;
        case 'Vein': // 정맥 - 혈관
            break;
        case 'Vessel': // 선박 - 배
            break;
        case 'VeterinaryCare': // 수의학 치료 - 동물 진료
            break;
        case 'VideoGallery': // 비디오 갤러리 - 영상 모음
            break;
        case 'VideoGame': // 비디오 게임 - 전자 오락
            break;
        case 'VideoGameClip': // 비디오 게임 클립 - 게임 영상 일부
            break;
        case 'VideoGameSeries': // 비디오 게임 시리즈 - 게임 연작
            break;
        case 'VideoObject': // 비디오 객체 - 영상 데이터
            break;
        case 'VideoObjectSnapshot': // 비디오 객체 스냅샷 - 영상 썸네일
            break;
        case 'ViewAction': // 보기 액션 - 열람 행위
            break;
        case 'VirtualLocation': // 가상 위치 - 온라인 장소
            break;
        case 'VisualArtsEvent': // 시각 예술 이벤트 - 미술 행사
            break;
        case 'VisualArtwork': // 시각 예술 작품 - 미술품
            break;
        case 'VitalSign': // 생체 징후 - 활력 징후
            break;
        case 'Volcano': // 화산 - 활화산
            break;
        case 'VoteAction': // 투표 액션 - 선거 행위
            break;
        case 'WantAction': // 원하기 액션 - 희망 행위
            break;
        case 'WarrantyPromise': // 보증 약속 - 품질 보증
            break;
        case 'WarrantyScope': // 보증 범위 - 보증 대상
            break;
        case 'WatchAction': // 시청 액션 - 관람 행위
            break;
        case 'Waterfall': // 폭포 - 낙수
            break;
        case 'WearAction': // 착용 액션 - 입기 행위
            break;
        case 'WearableMeasurementTypeEnumeration': // 의류 측정 유형 분류 - 의복 치수 종류
            break;
        case 'WearableSizeGroupEnumeration': // 의류 사이즈 그룹 분류 - 의복 크기 구분
            break;
        case 'WearableSizeSystemEnumeration': // 의류 사이즈 체계 분류 - 의복 치수 기준
            break;
        case 'WebAPI': // 웹 API - 웹 응용 프로그램 인터페이스
            break;
        case 'WebApplication': // 웹 응용프로그램 - 웹 앱
            break;
        case 'WebContent': // 웹 콘텐츠 - 웹 내용물
            break;
        case 'WebPage': // 웹 페이지 - 웹 문서
            $result = egb_schema_autoload($type, $dom, $data);
            break;
        case 'WebPageElement': // 웹 페이지 요소 - 웹 문서 구성물
            break;
        case 'WebSite': // 웹사이트 - 웹 사이트
            $result = egb_schema_autoload($type, $dom, $data);
            break;
        case 'WholesaleStore': // 도매점 - 도매상
            break;
        case 'WinAction': // 승리 액션 - 이기기 행위
            break;
        case 'Winery': // 와이너리 - 포도주 양조장
            break;
        case 'WorkBasedProgram': // 직장 기반 프로그램 - 현장 실습 과정
            break;
        case 'WorkersUnion': // 노동조합 - 근로자 단체
            break;
        case 'WriteAction': // 쓰기 액션 - 작성 행위
            break;
        case 'XPathType': // XPath 유형 - XML 경로 종류
            break;
        case 'Zoo': // 동물원 - 동물 사육 전시장
            break;
        default:
            error_log("Unknown schema type: {$type}");
        }
    return $result;
}

?>