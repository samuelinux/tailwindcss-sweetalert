# TailwindCSS + SweetAlert2 for Laravel

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-^8.1-777BB4.svg)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-10|11|12-FF2D20.svg)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-^3.0-FB70A9.svg)](https://livewire.laravel.com)

Pacote Laravel que injeta automaticamente **TailwindCSS** e **SweetAlert2** em toda resposta HTML.
Instale com um comando. Sem configuração. Sem build tools. Funciona na hora.

---

## 🎯 O que torna esse pacote único?

Diferente de outras soluções, este pacote resolve **dois problemas ao mesmo tempo** com **zero configuração**:

| Comparação       | Abordagem tradicional                                                         | Este pacote                                                 |
| ---------------- | ----------------------------------------------------------------------------- | ----------------------------------------------------------- |
| **TailwindCSS**  | Instalar Node.js, NPM, Vite, configurar `tailwind.config.js`, compilar        | `composer require` e pronto                                 |
| **SweetAlert2**  | Instalar via NPM/CDN, criar JS customizado, integrar com Livewire manualmente | Macros `$this->alert()` e `$this->confirm()` já disponíveis |
| **Configuração** | Editar layouts, adicionar `@vite`, `<link>`, `<script>`                       | Nenhuma — tudo é injetado automaticamente                   |
| **Dependências** | Node.js + NPM + Vite + PostCSS                                                | Apenas Composer                                             |
| **Deploy**       | Pipeline de build para CSS/JS                                                 | Sem build — assets vêm prontos no `vendor/`                 |

### 💡 Ideal para

- Projetos **TALL Stack** (Tailwind + Alpine.js + Laravel + Livewire) que querem começar rápido
- Equipes que preferem **não gerenciar Node.js/NPM** no servidor
- Pacotes Laravel que precisam de Tailwind sem afetar o projeto host
- **Prototipagem rápida** — monte um CRUD completo com alertas em minutos

---

## ✨ Funcionalidades

### 🎨 TailwindCSS Built-in

- TailwindCSS v2.2 completo, pronto para usar
- Injetado via `<link>` com **cache de 1 ano** (não impacta performance)
- Todas as classes utilitárias disponíveis sem compilação

### 🔔 SweetAlert2 Integrado ao Livewire

- Macros `$this->alert()` e `$this->confirm()` em qualquer componente
- Confirmações com callback automático — chama o método Livewire ao confirmar
- Totalmente customizável via opções do SweetAlert2
- 5 tipos de alerta: `success` · `error` · `warning` · `info` · `question`

### ⚡ Performance Otimizada

- Assets servidos via rotas HTTP com `Cache-Control: immutable`
- Browser baixa CSS/JS **uma única vez** e cacheia por 1 ano
- Páginas subsequentes carregam em milissegundos

### 🔒 Zero Configuração

- Middleware global auto-registrado
- Sem editar layouts, sem adicionar tags, sem tocar em nenhum arquivo
- Laravel Package Discovery cuida de tudo

---

## 🚀 Instalação

```bash
composer require samuelpereiramachado/tailwindcss-sweetalert
```

**É só isso.** Não precisa publicar configs, rodar migrations, nem editar nenhum arquivo.

---

## 🔧 Uso

### Alertas simples

Em qualquer componente Livewire:

```php
// Sucesso
$this->alert('Salvo!', 'Registro criado com sucesso.', 'success');

// Erro
$this->alert('Erro!', 'Não foi possível salvar.', 'error');

// Aviso com timer
$this->alert('Aviso', 'Sessão expira em breve.', 'warning', [
    'timer' => 3000,
    'showConfirmButton' => false,
]);
```

### Confirmação com callback

```php
// Pedir confirmação antes de executar
$this->confirm(
    title: 'Tem certeza?',
    action: ['method' => 'delete', 'params' => $id],
    message: 'Esta ação não pode ser desfeita.',
    type: 'warning'
);

// Método chamado automaticamente ao confirmar
public function delete($id)
{
    Model::findOrFail($id)->delete();
    $this->alert('Excluído!', 'Registro removido.', 'success');
}
```

### Exemplo completo em um Livewire Component

```php
class Usuarios extends Component
{
    public function criar()
    {
        User::create($this->form);
        $this->alert('Sucesso!', 'Usuário criado.', 'success');
    }

    public function confirmarExclusao($id)
    {
        $this->confirm(
            'Excluir usuário?',
            ['method' => 'excluir', 'params' => $id],
            'Todos os dados serão perdidos.',
            'warning'
        );
    }

    public function excluir($id)
    {
        User::findOrFail($id)->delete();
        $this->alert('Excluído!', 'Usuário removido.', 'success');
    }
}
```

---

## ⚙️ Como funciona por baixo

```
composer require → Laravel auto-registra o ServiceProvider
                          ↓
              ServiceProvider registra:
              ├── Rotas: /tailwindcss-sweetalert/css e /js
              ├── Middleware global: InjectAssets
              └── Macros Livewire: alert() e confirm()
                          ↓
              A cada request HTML:
              ├── Middleware injeta <link> antes de </head>
              └── Middleware injeta <script> antes de </body>
                          ↓
              Browser cacheia CSS/JS por 1 ano ✅
```

---

## 🏗️ Estrutura do pacote

```
├── composer.json
├── resources/
│   ├── css/tailwind.css                  # TailwindCSS v2.2 compilado
│   └── js/sweetalert2.all.min.js         # SweetAlert2 bundled
└── src/
    ├── TailwindcssSweetalertServiceProvider.php
    └── Http/
        ├── Controllers/
        │   └── AssetController.php       # Serve assets com cache 1 ano
        └── Middleware/
            └── InjectAssets.php          # Auto-injeta <link> e <script>
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
