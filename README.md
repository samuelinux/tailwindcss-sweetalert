# TALL Stack Components

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-^8.1-777BB4.svg)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-10|11|12-FF2D20.svg)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-^3.0-FB70A9.svg)](https://livewire.laravel.com)

Coleção de pacotes Laravel encapsulados para a **TALL Stack** (Tailwind CSS, Alpine.js, Laravel, Livewire). Todos os assets (CSS e JS) ficam no diretório `vendor`, sem dependência de Vite, NPM ou CDN.

---

## 📦 Pacotes

| Pacote         | Descrição                                           | Componente Blade  |
| -------------- | --------------------------------------------------- | ----------------- |
| **tall-twcss** | TailwindCSS v2.2 encapsulado                        | `<x-tall-twcss/>` |
| **tall-alert** | Alertas e confirmações com SweetAlert2 via Livewire | `<x-tall-alert/>` |

---

## 🚀 Instalação

Adicione os repositórios locais no `composer.json` do seu projeto Laravel:

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "packages/samuelpereiramachado/tall-twcss"
    },
    {
      "type": "path",
      "url": "packages/samuelpereiramachado/tall-alert"
    }
  ]
}
```

Instale os pacotes:

```bash
composer require samuelpereiramachado/tall-twcss
composer require samuelpereiramachado/tall-alert
```

Os Service Providers são registrados automaticamente via Laravel Package Discovery.

---

## 🔧 Uso

### TailwindCSS (`tall-twcss`)

Adicione o componente no seu layout Blade (geralmente em `<head>`):

```blade
<head>
    <x-tall-twcss/>
</head>
```

Isso injeta o TailwindCSS inline diretamente no HTML, sem necessidade de `<link>` externo.

### Alertas (`tall-alert`)

**1.** Adicione o componente no layout (antes de `</body>`):

```blade
<body>
    {{ $slot }}

    <x-tall-alert/>
</body>
```

**2.** Use os macros em qualquer componente Livewire:

```php
// Alerta simples
$this->alert('Sucesso!', 'Operação realizada.', 'success');

// Confirmação com callback
$this->confirm(
    title: 'Tem certeza?',
    action: ['method' => 'delete', 'params' => $id],
    message: 'Esta ação não pode ser desfeita.',
    type: 'warning'
);
```

**Tipos disponíveis:** `success`, `error`, `warning`, `info`, `question`

**3.** Implemente o método de callback no componente Livewire:

```php
public function delete($id)
{
    // Lógica de exclusão
    Model::findOrFail($id)->delete();
    $this->alert('Excluído!', 'Registro removido com sucesso.', 'success');
}
```

---

## 🏗️ Arquitetura

```
packages/samuelpereiramachado/
├── tall-twcss/
│   ├── composer.json
│   ├── resources/
│   │   ├── css/tailwind.css              # TailwindCSS compilado
│   │   └── views/components/
│   │       └── tall-twcss.blade.php      # Componente Blade
│   └── src/
│       ├── TallTwcssServiceProvider.php
│       └── Http/Controllers/
│           └── AssetController.php       # Fallback via rota HTTP
│
└── tall-alert/
    ├── composer.json
    ├── resources/
    │   ├── js/sweetalert2.all.min.js     # SweetAlert2 bundled
    │   └── views/components/
    │       └── tall-alert.blade.php      # Componente Blade + Alpine.js
    └── src/
        ├── TallAlertServiceProvider.php  # Macros Livewire (alert, confirm)
        └── Http/Controllers/
            └── AssetController.php
```

---

## 📋 Requisitos

- **PHP** >= 8.1
- **Laravel** 10, 11 ou 12
- **Livewire** >= 3.0 (apenas para `tall-alert`)

---

## 📄 Licença

MIT — veja [LICENSE](LICENSE) para detalhes.
