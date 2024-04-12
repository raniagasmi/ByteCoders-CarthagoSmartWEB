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

/* facture/edit.html.twig */
class __TwigTemplate_419bf64ac61f3efeda468832e1b59f39 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "facture/edit.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "facture/edit.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "facture/edit.html.twig", 1);
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

        echo "Modifier Facture";
        
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
        echo "<div class=\"container\">
    <div class=\"row justify-content-center mt-5 \">
        <div class=\"col-md-5\">
            <div class=\"card\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">Modifier une facture :</h5>
                    <!-- General Form Elements -->
                    ";
        // line 13
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 13, $this->source); })()), 'form_start');
        echo "
                    <!-- num facture-->
                    <div class=\"mb-3\">
                        <label for=\"idFacture\" class=\"form-label\">Num Facture:</label>
                    </div>
                    <!--id user-->
                <div class=\"row mb-3\">
                  <label for=\"IdUser\" class=\"col-sm-4 col-form-label\">User id : </label>
                  <div class=\"col-sm-10\">
                    ";
        // line 22
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 22, $this->source); })()), "idUser", [], "any", false, false, false, 22), 'widget', ["attr" => ["class" => "form-control"]]);
        echo "
                  </div>
                </div>
                    <!--libellé-->
                    <div class=\"mb-3\">
                        <label for=\"libelle\" class=\"form-label\">Libellé facture : </label>
                        ";
        // line 28
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 28, $this->source); })()), "libelle", [], "any", false, false, false, 28), 'widget', ["attr" => ["class" => "form-control"]]);
        echo "
                    </div>
                    <!-- Type de Facture -->
                    <div class=\"mb-3\">
                        <label class=\"form-label\">Type de Facture</label>
                        ";
        // line 33
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 33, $this->source); })()), "type", [], "any", false, false, false, 33), 'widget', ["attr" => ["class" => "form-select"]]);
        echo "
                    </div>
                    <!--date-->
                    <div class=\"mb-3\">
                        <label for=\"date\" class=\"form-label\">Date de création:</label>
                        ";
        // line 38
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 38, $this->source); })()), "date", [], "any", false, false, false, 38), 'widget', ["attr" => ["class" => "form-control"]]);
        echo "
                    </div>
                    <!--date d'écheance-->
                    <div class=\"mb-3\">
                        <label for=\"dateEch\" class=\"form-label\">Date d'écheance:</label>
                        ";
        // line 43
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 43, $this->source); })()), "dateEch", [], "any", false, false, false, 43), 'widget', ["attr" => ["class" => "form-control"]]);
        echo "
                    </div>
                    <!--Montant-->
                    <div class=\"mb-3\">
                        <label for=\"montant\" class=\"form-label\">Montant :</label>
                        ";
        // line 48
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 48, $this->source); })()), "montant", [], "any", false, false, false, 48), 'widget', ["attr" => ["class" => "form-control"]]);
        echo "
                    </div>
                    
                    <!--estPayee-->
                <div class=\"row mb-3\">
                    <label for=\"estPayee\" class=\"col-sm-4 col-form-label\">Payée ?</label>
                    <div class=\"col-sm-10\">
                        ";
        // line 55
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 55, $this->source); })()), "estPayee", [], "any", false, false, false, 55), 'widget');
        echo "
                    </div>
                </div>
                    <!--Update button-->
                    <div class=\"mb-3 text-center\">
                        ";
        // line 60
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 60, $this->source); })()), "Ajouter", [], "any", false, false, false, 60), 'widget', ["label" => "<i class=\"fas fa-save\"></i> Enregistrer", "label_html" => true, "attr" => ["class" => "btn btn-primary"]]);
        echo "
                    </div>
                    ";
        // line 62
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 62, $this->source); })()), 'form_end');
        echo "
                    <a href=\"";
        // line 63
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_facture_index");
        echo "\">back to list</a>
                </div>
            </div>
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
        return "facture/edit.html.twig";
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
        return array (  177 => 63,  173 => 62,  168 => 60,  160 => 55,  150 => 48,  142 => 43,  134 => 38,  126 => 33,  118 => 28,  109 => 22,  97 => 13,  88 => 6,  78 => 5,  59 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Modifier Facture{% endblock %}

{% block body %}
<div class=\"container\">
    <div class=\"row justify-content-center mt-5 \">
        <div class=\"col-md-5\">
            <div class=\"card\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">Modifier une facture :</h5>
                    <!-- General Form Elements -->
                    {{ form_start(form) }}
                    <!-- num facture-->
                    <div class=\"mb-3\">
                        <label for=\"idFacture\" class=\"form-label\">Num Facture:</label>
                    </div>
                    <!--id user-->
                <div class=\"row mb-3\">
                  <label for=\"IdUser\" class=\"col-sm-4 col-form-label\">User id : </label>
                  <div class=\"col-sm-10\">
                    {{ form_widget (form.idUser,{'attr':{'class':'form-control'}}) }}
                  </div>
                </div>
                    <!--libellé-->
                    <div class=\"mb-3\">
                        <label for=\"libelle\" class=\"form-label\">Libellé facture : </label>
                        {{ form_widget(form.libelle,{'attr':{'class':'form-control'}}) }}
                    </div>
                    <!-- Type de Facture -->
                    <div class=\"mb-3\">
                        <label class=\"form-label\">Type de Facture</label>
                        {{ form_widget(form.type, {'attr': {'class': 'form-select'}}) }}
                    </div>
                    <!--date-->
                    <div class=\"mb-3\">
                        <label for=\"date\" class=\"form-label\">Date de création:</label>
                        {{ form_widget(form.date,{'attr':{'class': 'form-control'}}) }}
                    </div>
                    <!--date d'écheance-->
                    <div class=\"mb-3\">
                        <label for=\"dateEch\" class=\"form-label\">Date d'écheance:</label>
                        {{ form_widget(form.dateEch, {'attr': {'class': 'form-control'}}) }}
                    </div>
                    <!--Montant-->
                    <div class=\"mb-3\">
                        <label for=\"montant\" class=\"form-label\">Montant :</label>
                        {{ form_widget(form.montant, {'attr': {'class': 'form-control'}}) }}
                    </div>
                    
                    <!--estPayee-->
                <div class=\"row mb-3\">
                    <label for=\"estPayee\" class=\"col-sm-4 col-form-label\">Payée ?</label>
                    <div class=\"col-sm-10\">
                        {{ form_widget(form.estPayee) }}
                    </div>
                </div>
                    <!--Update button-->
                    <div class=\"mb-3 text-center\">
                        {{ form_widget(form.Ajouter, {'label': '<i class=\"fas fa-save\"></i> Enregistrer', 'label_html': true, 'attr': {'class': 'btn btn-primary'}}) }}
                    </div>
                    {{ form_end(form)}}
                    <a href=\"{{ path('app_facture_index') }}\">back to list</a>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "facture/edit.html.twig", "C:\\Users\\dell\\Desktop\\ESPRIT\\pi_symfony\\ByteCoders-CarthagoSmartWEB\\templates\\facture\\edit.html.twig");
    }
}
