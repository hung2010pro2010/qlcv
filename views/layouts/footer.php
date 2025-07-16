 <!-- Thêm hạng mục tự động -->
<script>
document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch('index.php?controller=category&action=createAjax', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const select = document.getElementById('category');
            const newOption = document.createElement('option');
            newOption.value = data.id;
            newOption.textContent = data.name;
            newOption.selected = true;
            select.appendChild(newOption);
            $('#addCategoryModal').modal('hide');
            form.reset();
        } else {
            alert('Lỗi: ' + data.message);
        }
    });
});
</script>

<!-- Thông báo -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    function fetchNotifications() {
        fetch('index.php?controller=notification&action=fetch')
            .then(response => response.json())
            .then(data => {
                const container = document.querySelector('.dropdown-menu .menu');
                const labelCount = document.querySelector('.label-count');
                container.innerHTML = ''; // clear cũ

                if (data.length === 0) {
                    container.innerHTML = '<li><a><em>Không có thông báo nào</em></a></li>';
                    labelCount.textContent = '0';
                    return;
                }

                data.forEach(n => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <a href="javascript:void(0);">
                            <div class="icon-circle ${n.color}">
                                <i class="material-icons">${n.icon}</i>
                            </div>
                            <div class="menu-info">
                                <h4>${n.message}</h4>
                                <p><i class="material-icons">access_time</i> ${formatDate(n.created_at)}</p>
                            </div>
                        </a>`;
                    container.appendChild(li);
                });

                labelCount.textContent = data.length;
            });
    }

    function formatDate(str) {
        const d = new Date(str);
        return d.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' }) + ' ' +
               d.toLocaleDateString('vi-VN');
    }

    fetchNotifications(); // gọi lần đầu
    setInterval(fetchNotifications, 30000); // gọi mỗi 30s
});

document.querySelector('.dropdown-toggle').addEventListener('click', function () {
    fetch('index.php?controller=notification&action=markRead')
        .then(() => {
            const labelCount = document.querySelector('.label-count');
            labelCount.textContent = '0'; // reset số badge về 0
        });
});

</script>


<!-- Đổi màu -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const themeItems = document.querySelectorAll('.demo-choose-skin li');

    const match = document.cookie.match(/theme=(theme-[a-zA-Z0-9\-]+)/);
    if (match && match[1]) {
        document.body.className = match[1];
        themeItems.forEach(li => {
            li.classList.toggle('active', li.getAttribute('data-theme') === match[1].replace('theme-', ''));
        });
    }

    themeItems.forEach(function (el) {
        el.addEventListener('click', function () {
            const theme = this.getAttribute('data-theme');
            const className = 'theme-' + theme;
            document.body.className = className;
            document.cookie = "theme=" + className + "; path=/; max-age=" + (60 * 60 * 24 * 30);
            themeItems.forEach(li => li.classList.remove('active'));
            this.classList.add('active');
        });
    });
});

</script>


 <!-- Các tệp JS của AdminBSBM -->
    <!-- Jquery Core Js -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="assets/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="assets/plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="assets/plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="assets/plugins/raphael/raphael.min.js"></script>
    <script src="assets/plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="assets/plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="assets/plugins/flot-charts/jquery.flot.js"></script>
    <script src="assets/plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="assets/plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="assets/plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="assets/plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="assets/plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Custom Js -->
    <script src="assets/js/admin.js"></script>
    <script src="assets/js/pages/index.js"></script>
   
    <!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>





    <!-- Demo Js -->
    <script src="assets/js/demo.js"></script>


</body>
</html>
