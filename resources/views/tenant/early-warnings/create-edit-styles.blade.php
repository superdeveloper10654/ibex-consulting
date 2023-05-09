<style>
    .score-table td.selectable {
        border: solid 1px #fff;
        color: transparent;
        height: 50px;
        width: 50px;
        text-align: center;
        color: #fff;
        cursor: pointer;
    }

    .score-table .selected {
        color: #2a3042;
        font-weight: bold;
        outline: auto;
        outline-style: solid;
        outline-color: #2a3042;
    }

    .score-table .selected span {
        display: block;
        font-size: 8px;
        font-weight: 400;
    }

    tr#consequence:before {
        content: "";
    }
  
    tr#likelihood td:after {
        content: "Likelihood";
        display: block;
        transform: rotate(270deg);
        position: relative;
        left: 15px;
    }

    span.legend-colour {
        height: 10px;
        width: 10px;
        display: inline-block;
        margin-right: 8px;
    }

    span.legend-colour.slight {
        background: {{ AppTenant\Models\EarlyWarning::riskScoreColor(1) }};
    }

    span.legend-colour.trivial {
        background: {{ AppTenant\Models\EarlyWarning::riskScoreColor(5) }};
    }

    span.legend-colour.minor {
        background: {{ AppTenant\Models\EarlyWarning::riskScoreColor(10) }};
    }

    span.legend-colour.modest {
        background: {{ AppTenant\Models\EarlyWarning::riskScoreColor(15) }};
    }

    span.legend-colour.major {
        background: {{ AppTenant\Models\EarlyWarning::riskScoreColor(20) }};
    }

    span.legend-colour.critical {
        background: {{ AppTenant\Models\EarlyWarning::riskScoreColor(25) }};
    }
</style>