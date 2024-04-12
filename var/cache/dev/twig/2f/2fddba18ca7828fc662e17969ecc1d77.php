<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* facture/index.html.twig */
class __TwigTemplate_7264536d196c3619fc272689ddfaa8b4 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "facture/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "facture/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "facture/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo "Facture";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    // line 5
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        echo "<link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css\" rel=\"stylesheet\">
<section class=\"section\" style=\"display: flex;align-item:center;justify-content: center;margin-right: -200px\">
<div class=\"row\" style=\"display: flex;align-item:center;justify-content: center; margin-top: 150px\">

          <div class=\"card\">
            <div class=\"card-body\">
              <h5 class=\"card-title\">Liste des factures: (";
        // line 12
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["factures"]) || array_key_exists("factures", $context) ? $context["factures"] : (function () { throw new RuntimeError('Variable "factures" does not exist.', 12, $this->source); })()), "getTotalItemCount", [], "any", false, false, false, 12), "html", null, true);
        echo ")</h5>

              <!-- Table with stripped rows -->
              <table class=\"table table-sm table-striped\" >
                <thead>
                  <tr>
                <th>IdFacture</th>
                <th>Libelle</th>
                <th>Date</th>
                <th>DateEch</th>
                <th>Montant</th>
                <th>Type</th>
                <th>EstPayee</th>
                <th>IdUser</th>
                <th>actions</th>
            </tr>
                </thead>
                <tbody>
                  ";
        // line 30
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["factures"]) || array_key_exists("factures", $context) ? $context["factures"] : (function () { throw new RuntimeError('Variable "factures" does not exist.', 30, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["facture"]) {
            // line 31
            echo "            <tr>
                <td>";
            // line 32
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["facture"], "idFacture", [], "any", false, false, false, 32), "html", null, true);
            echo "</td>
                <td>";
            // line 33
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["facture"], "libelle", [], "any", false, false, false, 33), "html", null, true);
            echo "</td>
                <td>";
            // line 34
            ((twig_get_attribute($this->env, $this->source, $context["facture"], "date", [], "any", false, false, false, 34)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["facture"], "date", [], "any", false, false, false, 34), "Y-m-d"), "html", null, true))) : (print ("")));
            echo "</td>
                <td>";
            // line 35
            ((twig_get_attribute($this->env, $this->source, $context["facture"], "dateEch", [], "any", false, false, false, 35)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["facture"], "dateEch", [], "any", false, false, false, 35), "Y-m-d"), "html", null, true))) : (print ("")));
            echo "</td>
                <td>";
            // line 36
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["facture"], "montant", [], "any", false, false, false, 36), "html", null, true);
            echo "</td>
                <td>";
            // line 37
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["facture"], "type", [], "any", false, false, false, 37), "html", null, true);
            echo "</td>
                <td>
                    ";
            // line 39
            if (twig_get_attribute($this->env, $this->source, $context["facture"], "estPayee", [], "any", false, false, false, 39)) {
                // line 40
                echo "                    Oui
                    ";
            } else {
                // line 42
                echo "                    Non
                    ";
            }
            // line 44
            echo "                </td>

                <td>";
            // line 46
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["facture"], "idUser", [], "any", false, false, false, 46), "html", null, true);
            echo "</td>
                <td>
                    <a href=\"";
            // line 48
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_facture_show", ["idFacture" => twig_get_attribute($this->env, $this->source, $context["facture"], "idFacture", [], "any", false, false, false, 48)]), "html", null, true);
            echo "\"><i class=\"fas fa-eye\"></i></a>
                    <a href=\"";
            // line 49
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_facture_edit", ["idFacture" => twig_get_attribute($this->env, $this->source, $context["facture"], "idFacture", [], "any", false, false, false, 49)]), "html", null, true);
            echo "\"><i class=\"fas fa-edit\"></i> </a>
                    <a href=\"";
            // line 50
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_facture_delete", ["idFacture" => twig_get_attribute($this->env, $this->source, $context["facture"], "idFacture", [], "any", false, false, false, 50)]), "html", null, true);
            echo "\"><i class=\"fas fa-trash-alt\"></i></a>
                </td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 54
            echo "            <tr>
                <td colspan=\"9\">no records found</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['facture'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 58
        echo "                  
                </tbody>
              </table>

              <div style=\"display: flex;align-item:center;justify-content: center;\">
              ";
        // line 63
        echo $this->extensions['Knp\Bundle\PaginatorBundle\Twig\Extension\PaginationExtension']->render($this->env, (isset($context["factures"]) || array_key_exists("factures", $context) ? $context["factures"] : (function () { throw new RuntimeError('Variable "factures" does not exist.', 63, $this->source); })()));
        echo "
              </div>

              <a href=\"";
        // line 66
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_facture_new");
        echo "\"><i class=\"fas fa-plus\"></i>Créer facture</a>
              <!-- End small tables -->

            </div>
          </div>

        </div>


</div>
</section>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "facture/index.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  208 => 66,  202 => 63,  195 => 58,  186 => 54,  177 => 50,  173 => 49,  169 => 48,  164 => 46,  160 => 44,  156 => 42,  152 => 40,  150 => 39,  145 => 37,  141 => 36,  137 => 35,  133 => 34,  129 => 33,  125 => 32,  122 => 31,  117 => 30,  96 => 12,  88 => 6,  78 => 5,  59 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Facture{% endblock %}

{% block body %}
<link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css\" rel=\"stylesheet\">
<section class=\"section\" style=\"display: flex;align-item:center;justify-content: center;margin-right: -200px\">
<div class=\"row\" style=\"display: flex;align-item:center;justify-content: center; margin-top: 150px\">

          <div class=\"card\">
            <div class=\"card-body\">
              <h5 class=\"card-title\">Liste des factures: ({{ factures.getTotalItemCount }})</h5>

              <!-- Table with stripped rows -->
              <table class=\"table table-sm table-striped\" >
                <thead>
                  <tr>
                <th>IdFacture</th>
                <th>Libelle</th>
                <th>Date</th>
                <th>DateEch</th>
                <th>Montant</th>
                <th>Type</th>
                <th>EstPayee</th>
                <th>IdUser</th>
                <th>actions</th>
            </tr>
                </thead>
                <tbody>
                  {% for facture in factures %}
            <tr>
                <td>{{ facture.idFacture }}</td>
                <td>{{ facture.libelle }}</td>
                <td>{{ facture.date ? facture.date|date('Y-m-d') : '' }}</td>
                <td>{{ facture.dateEch ? facture.dateEch|date('Y-m-d') : '' }}</td>
                <td>{{ facture.montant }}</td>
                <td>{{ facture.type }}</td>
                <td>
                    {% if facture.estPayee %}
                    Oui
                    {% else %}
                    Non
                    {% endif %}
                </td>

                <td>{{ facture.idUser }}</td>
                <td>
                    <a href=\"{{ path('app_facture_show', {'idFacture': facture.idFacture}) }}\"><i class=\"fas fa-eye\"></i></a>
                    <a href=\"{{ path('app_facture_edit', {'idFacture': facture.idFacture}) }}\"><i class=\"fas fa-edit\"></i> </a>
                    <a href=\"{{ path('app_facture_delete', {'idFacture': facture.idFacture}) }}\"><i class=\"fas fa-trash-alt\"></i></a>
                </td>
            </tr>
        {% else %}
            <tr>
                <td colspan=\"9\">no records found</td>
            </tr>
        {% endfor %}
                  
                </tbody>
              </table>

              <div style=\"display: flex;align-item:center;justify-content: center;\">
              {{ knp_pagination_render(factures) }}
              </div>

              <a href=\"{{ path('app_facture_new') }}\"><i class=\"fas fa-plus\"></i>Créer facture</a>
              <!-- End small tables -->

            </div>
          </div>

        </div>


</div>
</section>
{% endblock %}
", "facture/index.html.twig", "C:\\Users\\dell\\Desktop\\ESPRIT\\pi_symfony\\ByteCoders-CarthagoSmartWEB\\templates\\facture\\index.html.twig");
    }
}
