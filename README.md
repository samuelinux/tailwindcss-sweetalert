# TailwindCSS + SweetAlert2 for Laravel

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-^8.1-777BB4.svg)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-10|11|12-FF2D20.svg)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-^3.0-FB70A9.svg)](https://livewire.laravel.com)

Pacote Laravel que injeta automaticamente **TailwindCSS** e **SweetAlert2** em toda resposta HTML. Zero configuração — basta instalar.

## ✨ Funcionalidades

- **TailwindCSS v2.2** — injetado inline antes de `</head>`
- **SweetAlert2** — injetado automaticamente antes de `</body>`
- **Macros Livewire** — `$this->alert()` e `$this->confirm()` disponíveis em qualquer componente
- **Zero configuração** — sem Vite, sem NPM, sem CDN, sem Blade components manuais
- **100% encapsulado** — todos os assets ficam no `vendor/`

---

## 🚀 Instalação

```bash
composer require samuelpereiramachado/tailwindcss-sweetalert
```

Pronto. O Service Provider é registrado automaticamente via Laravel Package Discovery.

---

## 🔧 Uso

### Alertas

Em qualquer componente Livewire:

```php
// Alerta simples
$this->alert('Sucesso!', 'Operação realizada com sucesso.', 'success');

// Com opções do SweetAlert2
$this->alert('Aviso', 'Atenção ao prazo.', 'warning', [
    'timer' => 3000,
    'showConfirmButton' => false,
]);
```

### Confirmações

```php
$this->confirm(
    title: 'Tem certeza?',
    action: ['method' => 'delete', 'params' => $id],
    message: 'Esta ação não pode ser desfeita.',
    type: 'warning'
);
```

Implemente o método de callback:

```php
public function delete($id)
{
    Model::findOrFail($id)->delete();
    $this->alert('Excluído!', 'Registro removido.', 'success');
}
```

**Tipos disponíveis:** `success` · `error` · `warning` · `info` · `question`

---

## ⚙️ Como funciona

O pacote registra um **middleware global** que intercepta toda resposta HTML:

1. Injeta `<style>` com TailwindCSS antes de `</head>`
2. Injeta `<script>` com SweetAlert2 + event listeners antes de `</body>`

Não é necessário adicionar nenhuma tag ou componente manualmente nos layouts.

---

## 🏗️ Estrutura

```
├── composer.json
├── resources/
│   ├── css/tailwind.css              # TailwindCSS v2.2 compilado
│   └── js/sweetalert2.all.min.js     # SweetAlert2 bundled
└── src/
    ├── TailwindcssSweetalertServiceProvider.php
    └── Http/Middleware/
        └── InjectAssets.php          # Middleware de auto-injeção
```

---

## 📋 Requisitos

| Dependência | Versão       |
| ----------- | ------------ |
| PHP         | >= 8.1       |
| Laravel     | 10, 11 ou 12 |
| Livewire    | >= 3.0       |

---

## 📄 Licença

MIT — veja [LICENSE](LICENSE) para detalhes.

---

**Autor:** Samuel Pereira Machado
