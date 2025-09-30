<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* sites/japachronicles.xyz/modules/custom/hiphop/templates/hiphop-article.html.twig */
class __TwigTemplate_03e9edd713e35c344e870c3038a2bd98 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 7
        yield "<article";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", ["hiphop-article"], "method", false, false, true, 7), "html", null, true);
        yield ">
  ";
        // line 8
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "jetpack_featured_media_url", [], "any", false, false, true, 8)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 9
            yield "    <div class=\"relative overflow-hidden\">
      <img src=\"";
            // line 10
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "jetpack_featured_media_url", [], "any", false, false, true, 10), "html", null, true);
            yield "\" 
           alt=\"";
            // line 11
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::striptags(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "title", [], "any", false, false, true, 11), "rendered", [], "any", false, false, true, 11)), "html", null, true);
            yield "\" 
           class=\"w-full h-48 object-cover transition-transform duration-300 hover:scale-105\"
           loading=\"lazy\">
      <div class=\"absolute top-4 left-4\">
        <span class=\"bg-red-600 text-white text-xs px-2 py-1 rounded-full font-medium\">HipHop</span>
      </div>
    </div>
  ";
        }
        // line 19
        yield "  
  <div class=\"p-6\">
    <div class=\"mb-4\">
      <span class=\"text-sm text-gray-500\">";
        // line 22
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["formatted_date"] ?? null), "html", null, true);
        yield "</span>
    </div>
    
    <h3 class=\"text-xl font-semibold text-gray-900 mb-3 line-clamp-2\">
      <a href=\"";
        // line 26
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "link", [], "any", false, false, true, 26), "html", null, true);
        yield "\" target=\"_blank\" rel=\"noopener\" class=\"hover:text-red-600 transition-colors duration-200\">
        ";
        // line 27
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "title", [], "any", false, false, true, 27), "rendered", [], "any", false, false, true, 27));
        yield "
      </a>
    </h3>
    
    ";
        // line 31
        if ((($tmp = ($context["excerpt"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 32
            yield "      <p class=\"text-gray-600 mb-4 line-clamp-3\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["excerpt"] ?? null), "html", null, true);
            yield "</p>
    ";
        }
        // line 34
        yield "    
    <div class=\"flex items-center justify-between\">
      <a href=\"";
        // line 36
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "link", [], "any", false, false, true, 36), "html", null, true);
        yield "\" target=\"_blank\" rel=\"noopener\" 
         class=\"inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors duration-200\">
        Read More
        <svg class=\"ml-2 w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
          <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14\"></path>
        </svg>
      </a>
      
      ";
        // line 44
        if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "jetpack_featured_media_url", [], "any", false, false, true, 44)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 45
            yield "        <span class=\"text-xs text-gray-400\">HipHop</span>
      ";
        }
        // line 47
        yield "    </div>
  </div>
</article>";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["attributes", "article", "formatted_date", "excerpt"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "sites/japachronicles.xyz/modules/custom/hiphop/templates/hiphop-article.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  121 => 47,  117 => 45,  115 => 44,  104 => 36,  100 => 34,  94 => 32,  92 => 31,  85 => 27,  81 => 26,  74 => 22,  69 => 19,  58 => 11,  54 => 10,  51 => 9,  49 => 8,  44 => 7,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "sites/japachronicles.xyz/modules/custom/hiphop/templates/hiphop-article.html.twig", "/var/www/html/web/sites/japachronicles.xyz/modules/custom/hiphop/templates/hiphop-article.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 8];
        static $filters = ["escape" => 7, "striptags" => 11, "raw" => 27];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape', 'striptags', 'raw'],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
