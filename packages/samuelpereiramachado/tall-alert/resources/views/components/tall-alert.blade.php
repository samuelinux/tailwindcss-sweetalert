<div x-data="{
    init() {
        window.addEventListener('tall-alert:alert', event => {
            const data = event.detail[0];
            Swal.fire({
                title: data.title,
                text: data.message,
                icon: data.type,
                ...data.options
            });
        });

        window.addEventListener('tall-alert:confirm', event => {
            const data = event.detail[0];
            const componentId = data.componentId;
            
            Swal.fire({
                title: data.title,
                text: data.message,
                icon: data.type,
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                ...data.options
            }).then((result) => {
                if (result.isConfirmed) {
                    const component = Livewire.find(componentId);
                    if (component) {
                        if (data.action.params) {
                            component.call(data.action.method, data.action.params);
                        } else {
                            component.call(data.action.method);
                        }
                    }
                }
            });
        });
    }
}">
    <script src="{{ route('tall-alert.assets.js') }}"></script>
</div>
