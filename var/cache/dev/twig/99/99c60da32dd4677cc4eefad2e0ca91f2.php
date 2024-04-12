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

/* facture/new.html.twig */
class __TwigTemplate_5bfbd8e192d85a278a75a4f327b8f4ec extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "facture/new.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "facture/new.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "facture/new.html.twig", 1);
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

        echo "Créer Facture";
        
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
        echo "
   <div style=\"display: flex; justify-content: center; align-items: center; margin-top: 150px; padding: 10px;\">
          <div class=\"card\">
            <div class=\"card-body\">
              <a href=\"";
        // line 10
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_facture_index");
        echo "\"><i class=\"ri-arrow-left-circle-fill\" style=\"font-size: 50px;\"></i></a>

              <h5 class=\"card-title\">Ajouter une facture :</h5>
              <!-- General Form Elements -->
              ";
        // line 14
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 14, $this->source); })()), 'form_start', ["attr" => ["novalidate" => "novalidate"]]);
        echo "
              <!-- num facture-->
                <div class=\"row mb-3\">
                  <label for=\"idFacture\" class=\"col-sm-4 col-form-label\">Num Facture:</label>
                  <!--<div class=\"col-sm-10\">
                    
                  </div>-->
                </div>
                <!--id user-->
                <div class=\"row mb-3\">
                  <label for=\"IdUser\" class=\"col-sm-4 col-form-label\">User id : </label>
                  <div class=\"col-sm-10\">
                    ";
        // line 26
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 26, $this->source); })()), "idUser", [], "any", false, false, false, 26), 'widget', ["attr" => ["class" => "form-control"]]);
        echo "
                    ";
        // line 27
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 27, $this->source); })()), "idUser", [], "any", false, false, false, 27), 'errors', ["attr" => ["class" => "text-danger"]]);
        echo "
                  </div>
                </div>
                <!--libellé-->
                <div class=\"row mb-3\">
                  <label for=\"libelle\" class=\"col-sm-4 col-form-label\">Libellé facture : </label>
                  <div class=\"col-sm-10\">
                    ";
        // line 34
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 34, $this->source); })()), "libelle", [], "any", false, false, false, 34), 'widget', ["attr" => ["class" => "form-control"]]);
        echo "
                    ";
        // line 35
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 35, $this->source); })()), "libelle", [], "any", false, false, false, 35), 'errors', ["attr" => ["class" => "text-danger"]]);
        echo "
                  </div>
                </div>
                
                <!-- type de facture-->
                <div class=\"row mb-3\">
                    <label for=\"type\" class=\"col-sm-4 col-form-label\">Type de Facture</label>
                    <div class=\"col-sm-10\">
                        ";
        // line 43
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 43, $this->source); })()), "type", [], "any", false, false, false, 43), 'widget', ["attr" => ["class" => "form-select"]]);
        echo "
                        ";
        // line 44
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 44, $this->source); })()), "type", [], "any", false, false, false, 44), 'errors', ["attr" => ["class" => "text-danger"]]);
        echo "
                    </div>
                </div>


                <!--date-->
                <div class=\"row mb-3\">
                  <label for=\"date\" class=\"col-sm-4 col-form-label\">Date de création:</label>
                  <div class=\"col-sm-10\">
                    ";
        // line 53
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 53, $this->source); })()), "date", [], "any", false, false, false, 53), 'widget', ["attr" => ["class" => "form-control"]]);
        echo "
                    ";
        // line 54
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 54, $this->source); })()), "date", [], "any", false, false, false, 54), 'errors', ["attr" => ["class" => "text-danger"]]);
        echo "
                  </div>
                </div>
                <!--date d'écheance-->
                <div class=\"row mb-3\">
                  <label for=\"dateEch\" class=\"col-sm-4 col-form-label\">Date d'écheance:</label>
                  <div class=\"col-sm-10\">
                    ";
        // line 61
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 61, $this->source); })()), "dateEch", [], "any", false, false, false, 61), 'widget', ["attr" => ["class" => "form-control"]]);
        echo "
                    ";
        // line 62
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 62, $this->source); })()), "dateEch", [], "any", false, false, false, 62), 'errors', ["attr" => ["class" => "text-danger"]]);
        echo "
                  </div>
                </div>

                <!--Montant-->
                <div class=\"row mb-3\">
                  <label for=\"montant\" class=\"col-sm-4 col-form-label\">Montant :</label>
                  <div class=\"col-sm-10\">
                    ";
        // line 70
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 70, $this->source); })()), "montant", [], "any", false, false, false, 70), 'widget', ["attr" => ["class" => "form-control"]]);
        echo "
                    ";
        // line 71
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 71, $this->source); })()), "montant", [], "any", false, false, false, 71), 'errors', ["attr" => ["class" => "text-danger"]]);
        echo "
                  </div>
                </div>
                <!--estPayee-->
                <div class=\"row mb-3\">
                    <label for=\"estPayee\" class=\"col-sm-4 col-form-label\">Payée ?</label>
                    <div class=\"col-sm-10\">
                        ";
        // line 78
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 78, $this->source); })()), "estPayee", [], "any", false, false, false, 78), 'widget');
        echo "
                    </div>
                </div>
                
                        <!--Ajouter button-->
                <div class=\"row mb-3\" >
                  <div class=\"col-sm-10\" style=\"display: flex;align-items: center;justify-content: center\">
                    ";
        // line 85
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 85, $this->source); })()), "Ajouter", [], "any", false, false, false, 85), 'widget', ["attr" => ["class" => "btn btn-primary"]]);
        echo "
                  </div>
                </div>

              ";
        // line 89
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 89, $this->source); })()), 'form_end');
        echo "

            </div>
          </div>

        </div>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "facture/new.html.twig";
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
        return array (  221 => 89,  214 => 85,  204 => 78,  194 => 71,  190 => 70,  179 => 62,  175 => 61,  165 => 54,  161 => 53,  149 => 44,  145 => 43,  134 => 35,  130 => 34,  120 => 27,  116 => 26,  101 => 14,  94 => 10,  88 => 6,  78 => 5,  59 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Créer Facture{% endblock %}

{% block body %}

   <div style=\"display: flex; justify-content: center; align-items: center; margin-top: 150px; padding: 10px;\">
          <div class=\"card\">
            <div class=\"card-body\">
              <a href=\"{{ path('app_facture_index') }}\"><i class=\"ri-arrow-left-circle-fill\" style=\"font-size: 50px;\"></i></a>

              <h5 class=\"card-title\">Ajouter une facture :</h5>
              <!-- General Form Elements -->
              {{ form_start(form, {attr:{'novalidate':'novalidate'}}) }}
              <!-- num facture-->
                <div class=\"row mb-3\">
                  <label for=\"idFacture\" class=\"col-sm-4 col-form-label\">Num Facture:</label>
                  <!--<div class=\"col-sm-10\">
                    
                  </div>-->
                </div>
                <!--id user-->
                <div class=\"row mb-3\">
                  <label for=\"IdUser\" class=\"col-sm-4 col-form-label\">User id : </label>
                  <div class=\"col-sm-10\">
                    {{ form_widget (form.idUser,{'attr':{'class':'form-control'}}) }}
                    {{ form_errors (form.idUser,{'attr':{'class':'text-danger'}}) }}
                  </div>
                </div>
                <!--libellé-->
                <div class=\"row mb-3\">
                  <label for=\"libelle\" class=\"col-sm-4 col-form-label\">Libellé facture : </label>
                  <div class=\"col-sm-10\">
                    {{ form_widget (form.libelle,{'attr':{'class':'form-control'}}) }}
                    {{ form_errors (form.libelle,{'attr':{'class':'text-danger'}}) }}
                  </div>
                </div>
                
                <!-- type de facture-->
                <div class=\"row mb-3\">
                    <label for=\"type\" class=\"col-sm-4 col-form-label\">Type de Facture</label>
                    <div class=\"col-sm-10\">
                        {{ form_widget(form.type, {'attr': {'class': 'form-select'}}) }}
                        {{ form_errors(form.type, {'attr': {'class': 'text-danger'}}) }}
                    </div>
                </div>


                <!--date-->
                <div class=\"row mb-3\">
                  <label for=\"date\" class=\"col-sm-4 col-form-label\">Date de création:</label>
                  <div class=\"col-sm-10\">
                    {{form_widget (form.date,{'attr':{'class': 'form-control'}})}}
                    {{form_errors (form.date,{'attr':{'class': 'text-danger'}})}}
                  </div>
                </div>
                <!--date d'écheance-->
                <div class=\"row mb-3\">
                  <label for=\"dateEch\" class=\"col-sm-4 col-form-label\">Date d'écheance:</label>
                  <div class=\"col-sm-10\">
                    {{ form_widget(form.dateEch, {'attr': {'class': 'form-control'}}) }}
                    {{ form_errors(form.dateEch, {'attr': {'class': 'text-danger'}}) }}
                  </div>
                </div>

                <!--Montant-->
                <div class=\"row mb-3\">
                  <label for=\"montant\" class=\"col-sm-4 col-form-label\">Montant :</label>
                  <div class=\"col-sm-10\">
                    {{ form_widget(form.montant, {'attr': {'class': 'form-control'}}) }}
                    {{ form_errors(form.montant, {'attr': {'class': 'text-danger'}}) }}
                  </div>
                </div>
                <!--estPayee-->
                <div class=\"row mb-3\">
                    <label for=\"estPayee\" class=\"col-sm-4 col-form-label\">Payée ?</label>
                    <div class=\"col-sm-10\">
                        {{ form_widget(form.estPayee) }}
                    </div>
                </div>
                
                        <!--Ajouter button-->
                <div class=\"row mb-3\" >
                  <div class=\"col-sm-10\" style=\"display: flex;align-items: center;justify-content: center\">
                    {{ form_widget(form.Ajouter,{'attr':{'class':'btn btn-primary'}})}}
                  </div>
                </div>

              {{ form_end(form)}}

            </div>
          </div>

        </div>
{% endblock %}
", "facture/new.html.twig", "C:\\Users\\dell\\Desktop\\ESPRIT\\pi_symfony\\ByteCoders-CarthagoSmartWEB\\templates\\facture\\new.html.twig");
    }
}
