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
        if (! str_contains($content, '</head>')) {
            return $content;
        }

        $cssUrl = route('tailwindcss-sweetalert.css');
        $linkTag = "\n<link rel=\"stylesheet\" href=\"{$cssUrl}\">\n";

        return str_replace('</head>', $linkTag . '</head>', $content);
    }

    protected function injectJs(string $content): string
    {
        if (! str_contains($content, '</body>')) {
            return $content;
        }

        $jsUrl = route('tailwindcss-sweetalert.js');

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
                if (!data.action || !data.action.method) {
                    console.error('[tailwindcss-sweetalert] confirm: "action.method" é obrigatório.');
                    return;
                }
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

        $scriptTag = "\n<script src=\"{$jsUrl}\"></script>\n{$alertListener}\n";

        return str_replace('</body>', $scriptTag . '</body>', $content);
    }
}
