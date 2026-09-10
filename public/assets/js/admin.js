document.addEventListener('DOMContentLoaded', function () {
    // 1. Quản lý Màn hình chờ (Preloader)
    const preloader = document.getElementById('page-preloader');

    // Tự động ẩn Preloader khi trang đã tải xong
    if (preloader) {
        preloader.style.opacity = '0';
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 300);
    }

    // Xử lý bật/tắt Preloader khi chuyển trang hoặc bấm nút xóa
    document.addEventListener('click', function (e) {
        const link = e.target.closest('a');
        if (!link) return;

        const href = link.getAttribute('href');
        // Bỏ qua các link nội bộ, javascript hoặc mở tab mới
        if (!href || href.startsWith('#') || href.startsWith('javascript:') || link.target === '_blank') {
            return;
        }

        // Đợi kiểm tra sự kiện xem người dùng có bấm "Hủy" ở confirm() hay không
        setTimeout(() => {
            if (e.defaultPrevented) {
                // Nếu bấm "Hủy" (event bị hủy), ẩn Preloader ngay lập tức
                if (preloader) {
                    preloader.style.display = 'none';
                    preloader.style.opacity = '0';
                }
            } else if (preloader) {
                // Nếu bấm "OK" hoặc chuyển trang bình thường, hiển thị Preloader
                preloader.style.display = 'flex';
                preloader.style.opacity = '1';
            }
        }, 10);
    });

    // 2. Xử lý toggle Menu Ba Chấm (Action Dropdown)
    const actionBtns = document.querySelectorAll('.action-btn');

    actionBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const currentMenu = this.nextElementSibling;
            
            // Đóng tất cả menu ba chấm khác đang mở
            document.querySelectorAll('.action-menu.show').forEach(menu => {
                if (menu !== currentMenu) {
                    menu.classList.remove('show');
                    if (menu.previousElementSibling) {
                        menu.previousElementSibling.classList.remove('active');
                    }
                }
            });

            // Bật/tắt menu hiện tại
            if (currentMenu) {
                const isOpen = currentMenu.classList.toggle('show');
                this.classList.toggle('active', isOpen);
            }
        });
    });

    // Bấm ra ngoài vùng menu -> Tự động đóng tất cả dropdown
    document.addEventListener('click', function () {
        document.querySelectorAll('.action-menu.show').forEach(menu => {
            menu.classList.remove('show');
            if (menu.previousElementSibling) {
                menu.previousElementSibling.classList.remove('active');
            }
        });
    });

    // 3. Xử lý Tự động ẩn và Nút đóng (✕) cho Thông Báo Flash
    const alerts = document.querySelectorAll('.glass-alert');
    alerts.forEach(alert => {
        // Tự động ẩn sau 4 giây
        const timer = setTimeout(() => {
            dismissAlert(alert);
        }, 4000);

        // Bấm nút ✕ để tắt ngay lập tức
        const closeBtn = alert.querySelector('.alert-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                clearTimeout(timer);
                dismissAlert(alert);
            });
        }
    });

    function dismissAlert(alertEl) {
        alertEl.style.transition = 'opacity 0.4s ease, transform 0.4s ease, margin 0.4s ease, padding 0.4s ease';
        alertEl.style.opacity = '0';
        alertEl.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            alertEl.remove();
        }, 400);
    }
});

/* Script xử lý chuyển Tab & Lưu trạng thái cho trang Settings */
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.settings-tab-btn');
    const tabPanes = document.querySelectorAll('.settings-tab-pane');
    
    // Chỉ chạy script nếu đang ở trang có chứa settings-tabs
    if (tabBtns.length > 0 && tabPanes.length > 0) {
        const activeTabId = localStorage.getItem('vc_active_settings_tab') || 'tab-general';
        
        function activateTab(tabId) {
            tabBtns.forEach(btn => {
                btn.classList.toggle('active', btn.dataset.target === tabId);
            });
            tabPanes.forEach(pane => {
                pane.classList.toggle('active', pane.id === tabId);
            });
            localStorage.setItem('vc_active_settings_tab', tabId);
        }

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                activateTab(this.dataset.target);
            });
        });

        activateTab(activeTabId);
    }
});

function getSubUrl(uuid) {
    return window.location.origin + '/sub?token=' + uuid;
}

function copySubLink(uuid) {
    const url = getSubUrl(uuid);
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(() => {
            alert('Đã sao chép liên kết đăng ký vào bộ nhớ tạm!');
        }).catch(() => {
            fallbackCopyText(url);
        });
    } else {
        fallbackCopyText(url);
    }
}

function fallbackCopyText(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        alert('Đã sao chép liên kết đăng ký vào bộ nhớ tạm!');
    } catch (err) {
        alert('Không thể tự động sao chép. Vui lòng thử lại!');
    }
    document.body.removeChild(textArea);
}

function openQrModal(uuid) {
    const url = getSubUrl(uuid);
    const qrImg = document.getElementById('qrCodeImg');
    if (qrImg) {
        qrImg.src = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' + encodeURIComponent(url);
    }
    const modal = document.getElementById('qrModal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

function closeQrModal() {
    const modal = document.getElementById('qrModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

function updatePriceHint(selectEl) {
    if (!selectEl) return;
    const selectedOption = selectEl.options[selectEl.selectedIndex];
    const price = selectedOption ? selectedOption.getAttribute('data-price') : null;
    const amountInput = document.getElementById('amount_input');
    if (price !== null && amountInput) {
        amountInput.value = price;
    }

    function toggleSelectAllNodes(masterCheckbox) {
    const checkboxes = document.querySelectorAll('.node-checkbox');
    checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
}

function confirmBulkDeleteNodes() {
    const selected = document.querySelectorAll('.node-checkbox:checked');
    if (selected.length === 0) {
        alert('Vui lòng chọn ít nhất một nút kết nối để xóa!');
        return;
    }
    if (confirm(`Bạn có chắc chắn muốn xóa vĩnh viễn ${selected.length} nút kết nối đã chọn?`)) {
        document.getElementById('bulkDeleteForm').submit();
    }
}
}