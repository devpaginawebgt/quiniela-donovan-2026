import { initTermsModal } from '../components/terms-modal';

const initEmployeePositionSync = () => {
    const select = document.getElementById('employee_id');
    const positionInput = document.getElementById('employee_position');

    if (!select || !positionInput) {
        return;
    }

    const syncPosition = () => {
        const option = select.options[select.selectedIndex];
        positionInput.value = option?.dataset.position ?? '';
    };

    select.addEventListener('change', syncPosition);
    syncPosition();
};

document.addEventListener('DOMContentLoaded', () => {
    initTermsModal();
    initEmployeePositionSync();
});
