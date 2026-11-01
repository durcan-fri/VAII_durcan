<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<!-- Nadpis sekcie + Tlačidlo pridať -->
<div class="page-header">
    <h1>Materiál</h1>
    <button type="button" class="btn btn-add">
        <span class="plus-icon">+</span> Pridať materiál
    </button>
</div>

<!-- Karta s tabuľkou a filtrami -->
<section class="card-container">
    <div class="card-toolbar">
        <h2>Zoznam materiálov</h2>
        <div class="toolbar-actions">
            <div class="search-input-wrapper">
                <svg class="search-icon" viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" placeholder="Hľadať materiál">
            </div>
            <button type="button" class="btn btn-filter">
                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                Filtruj
            </button>
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
            <tr>
                <th>Názov materiálu</th>
                <th>Kód</th>
                <th>Na sklade</th>
                <th>Jednotka</th>
                <th>Sklad</th>
                <th>Stav</th>
                <th>Operácie</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="font-bold">Oceľový profil 40×40</td>
                <td>PR-40-40</td>
                <td>124</td>
                <td>ks</td>
                <td>Hlavný</td>
                <td><span class="badge badge-active">Aktívny</span></td>
                <td>
                    <div class="actions-group">
                        <button class="btn-action">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            Zobraziť
                        </button>
                        <button class="btn-action">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                            Upraviť
                        </button>
                        <button class="btn-action">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            Zmazať
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="font-bold">Doska 18 mm</td>
                <td>PL-18</td>
                <td>18</td>
                <td>m²</td>
                <td>Hlavný</td>
                <td><span class="badge badge-active">Aktívny</span></td>
                <td>
                    <div class="actions-group">
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Zobraziť</button>
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg> Upraviť</button>
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Zmazať</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="font-bold">Hliníkový profil 30×30</td>
                <td>AL-30-30</td>
                <td>42</td>
                <td>ks</td>
                <td>Rezervný</td>
                <td><span class="badge badge-reserve">Rezerva</span></td>
                <td>
                    <div class="actions-group">
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Zobraziť</button>
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg> Upraviť</button>
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Zmazať</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="font-bold">Čierne PVC rúrky 16 mm</td>
                <td>PVC-16</td>
                <td>86</td>
                <td>ks</td>
                <td>Hlavný</td>
                <td><span class="badge badge-active">Aktívny</span></td>
                <td>
                    <div class="actions-group">
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Zobraziť</button>
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg> Upraviť</button>
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Zmazať</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="font-bold">Kábel 3×1,5 mm²</td>
                <td>KB-3-1.5</td>
                <td>31</td>
                <td>m</td>
                <td>Rezervný</td>
                <td><span class="badge badge-reserve">Rezerva</span></td>
                <td>
                    <div class="actions-group">
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Zobraziť</button>
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg> Upraviť</button>
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Zmazať</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="font-bold">Ochranná fólia 0,5 mm</td>
                <td>FO-0.5</td>
                <td>12</td>
                <td>m²</td>
                <td>Hlavný</td>
                <td><span class="badge badge-active">Aktívny</span></td>
                <td>
                    <div class="actions-group">
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Zobraziť</button>
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg> Upraviť</button>
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Zmazať</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="font-bold">Ochranné rukavice - veľkosť 8</td>
                <td>PG-8</td>
                <td>0</td>
                <td>ks</td>
                <td>Hlavný</td>
                <td><span class="badge badge-critical">Kritický</span></td>
                <td>
                    <div class="actions-group">
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Zobraziť</button>
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg> Upraviť</button>
                        <button class="btn-action"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Zmazať</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</section>
