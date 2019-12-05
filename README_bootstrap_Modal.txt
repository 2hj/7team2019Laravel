:: Modal기능 사용하기 ::

Modal 이란? : alert메시지가 아닌 레이어 팝업창

Bootstrap의 자바스크립트 Modal플러그인을 사용한다.
https://getbootstrap.com/docs/4.4/components/modal

# 모달을 띄울 <button>의 필수속성
data-toggle="modal" data-target="#exampleModal"
==> data-toggle : 해당 버튼이 모달을 띄울 것임을 의미
    data-target : 모달 창이 될 요소의 id값을 가리킴

# 모달 생성 : 
<div class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <div class="modal-footer">


# jQuery를 통해 모달 창을 띄운다.
$('#myModal').modal() : 해당 콘텐츠를 모달로 활성화
$('#myModal').modal('show') : 모달을 화면에 띄움

자세한 모달의 메소드는 부트스트랩의 모달 메소드 페이지를 참조.
https://getbootstrap.com/docs/4.4/components/modal/#methods
