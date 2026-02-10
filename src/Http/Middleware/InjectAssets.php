<?php

namespace SamuelPereiraMachado\TailwindcssSweetalert\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InjectAssets
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (! $response instanceof Response) {
            return $response;
        }

        if (! str_contains($response->headers->get('Content-Type', ''), 'text/html')) {
            return $response;
        }

        $content = $response->getContent();

        if (! is_string($content)) {
            return $response;
        }

        $content = $this->injectCss($content);
        $content = $this->injectJs($content);

        $response->setContent($content);

        return $response;
    }

    protected function injectCss(string $content): string
    {
        $cssPath = __DIR__ . '/../../../resources/css/tailwind.css';

        if (! file_exists($cssPath) || ! str_contains($content, '</head>')) {
            return $content;
        }

        $css = file_get_contents($cssPath);
        $styleTag = "\n<style>{$css}</style>\n";

        return str_replace('</head>', $styleTag . '</head>', $content);
    }

    protected function injectJs(string $content): string
    {
        $jsPath = __DIR__ . '/../../../resources/js/sweetalert2.all.min.js';

        if (! file_exists($jsPath) || ! str_contains($content, '</body>')) {
            return $content;
        }

        $js = file_get_contents($jsPath);

        $alertListener = <<<'JS'
<script>
(function() {
    if (window.__tallAlertInitialized) return;

    window.addEventListener('tall-alert:alert', function(event) {
        var data = event.detail[0];
        Swal.fire(Object.assign({
            title: data.title,
            text: data.message,
            icon: data.type
        }, data.options || {}));
    });

    window.addEventListener('tall-alert:confirm', function(event) {
        var data = event.detail[0];
        var componentId = data.componentId;

        Swal.fire(Object.assign({
            title: data.title,
            text: data.message,
            icon: data.type,
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
        }, data.options || {})).then(function(result) {
            if (result.isConfirmed) {
                var component = Livewire.find(componentId);
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

    window.__tallAlertInitialized = true;
})();
</script>
JS;

        $scriptTag = "\n<script>{$js}</script>\n{$alertListener}\n";

        return str_replace('</body>', $scriptTag . '</body>', $content);
    }
}
