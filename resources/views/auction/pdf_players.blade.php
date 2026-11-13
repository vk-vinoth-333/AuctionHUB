@php
    use Illuminate\Support\Str;

    /* =====================================================================
     |  LAYOUT SETTINGS
     | ===================================================================== */
    $columns = 3; // cards per row
    $gap = 5; // space between cards (pt) - REDUCED to help fit rows
    $fs = 8.5; // base font size (pt) - SLIGHTLY REDUCED to tighten card height

    // Detail lines shown under the name + number, one per line, in this order.
    // Available: phone, role, style, batting, bowling, email, base_price
    $layout = ['phone', 'role', 'style'];

    // Write-in lines at the bottom of each card
    $blanks = ['T', 'P'];

    $labels = [
        'phone' => 'Ph:',
        'role' => 'Role:',
        'style' => 'Bat/Bowl:',
        'batting' => 'Bat:',
        'bowling' => 'Bowl:',
        'email' => 'Mail:',
        'base_price' => 'Base:',
    ];

    $roles = [1 => 'Batsman', 2 => 'Bowler', 3 => 'WK', 4 => 'AR'];

    /* =====================================================================
     |  SIZES (A4 portrait, margins 24pt left/right)
     | ===================================================================== */
    $pageWidth = 547; // 595 - 2*24
    $cardW = (int) floor(($pageWidth - $gap * ($columns + 1)) / $columns);

    $lineH = 11; // height of every text line (pt) - REDUCED to save vertical space
    $infoLines = 2 + count($layout) + count($blanks);
    $infoH = $infoLines * $lineH + 1.5;

    $photoCellW = 68;
    $photoW = 64;
    $photoH = (int) floor($infoH) - 1;

    $cardH = $infoH + 6 + 3 + 2; // + padding + top bar + borders

    // Width available inside the info column
    $infoW = $cardW - $photoCellW - 10 - 2;

    /* =====================================================================
     |  HELPERS
     | ===================================================================== */
    $photoData = function (?string $relative, int $wPt, int $hPt) {
        if (!$relative || !function_exists('imagecreatefromstring')) {
            return null;
        }
        $path = storage_path('app/public/' . $relative);
        if (!is_file($path)) {
            return null;
        }

        $raw = @file_get_contents($path);
        $src = $raw ? @imagecreatefromstring($raw) : false;
        if (!$src) {
            return null;
        }

        if (
            function_exists('exif_read_data') &&
            in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['jpg', 'jpeg'])
        ) {
            $exif = @exif_read_data($path);
            $angle = [3 => 180, 6 => -90, 8 => 90][$exif['Orientation'] ?? 1] ?? 0;
            if ($angle) {
                $rot = @imagerotate($src, $angle, 0);
                if ($rot) {
                    imagedestroy($src);
                    $src = $rot;
                }
            }
        }

        $sw = imagesx($src);
        $sh = imagesy($src);
        $scale = 4;
        $tw = $wPt * $scale;
        $th = $hPt * $scale;
        $targetRatio = $tw / $th;

        if ($sw / $sh > $targetRatio) {
            $cropH = $sh;
            $cropW = (int) round($sh * $targetRatio);
            $cropX = (int) round(($sw - $cropW) / 2);
            $cropY = 0;
        } else {
            $cropW = $sw;
            $cropH = (int) round($sw / $targetRatio);
            $cropX = 0;
            $cropY = (int) round(($sh - $cropH) * 0.3);
        }

        $dst = imagecreatetruecolor($tw, $th);
        imagefill($dst, 0, 0, imagecolorallocate($dst, 243, 244, 246));
        imagecopyresampled($dst, $src, 0, 0, $cropX, $cropY, $tw, $th, $cropW, $cropH);

        ob_start();
        imagejpeg($dst, null, 82);
        $jpeg = ob_get_clean();
        imagedestroy($src);
        imagedestroy($dst);

        return 'data:image/jpeg;base64,' . base64_encode($jpeg);
    };

    $logoData = function (?string $relative, int $maxW, int $maxH) {
        if (!$relative) {
            return null;
        }
        $path = storage_path('app/public/' . $relative);
        if (!is_file($path)) {
            return null;
        }
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mime = ['jpg' => 'jpeg', 'jpeg' => 'jpeg', 'png' => 'png', 'gif' => 'gif', 'svg' => 'svg+xml'][$ext] ?? null;
        if (!$mime) {
            return null;
        }
        $w = $maxW;
        $h = $maxH;
        $size = @getimagesize($path);
        if ($size && $size[0] && $size[1]) {
            $s = min($maxW / $size[0], $maxH / $size[1]);
            $w = (int) round($size[0] * $s);
            $h = (int) round($size[1] * $s);
        }
        return [
            'src' => 'data:image/' . $mime . ';base64,' . base64_encode(file_get_contents($path)),
            'w' => $w,
            'h' => $h,
        ];
    };

    $resolve = function (string $key, $player) use ($roles) {
        $d = $player->detail;
        $bat = $d->batting_style ?? null;
        $bowl = $d->bowling_style ?? null;
        $batTxt = $bat === 'right_handed' ? 'RH' : ($bat === 'left_handed' ? 'LH' : '-');
        $bowlTxt = $bowl === 'right' ? 'R' : ($bowl === 'left' ? 'L' : 'N/A');

        switch ($key) {
            case 'phone':
                return $player->phone ?: null;
            case 'role':
                return $roles[$d->role ?? 0] ?? null;
            case 'email':
                return $player->email ? Str::limit($player->email, 18, '..') : null;
            case 'batting':
                return $batTxt;
            case 'bowling':
                return $bowlTxt;
            case 'style':
                return $batTxt . ' | ' . $bowlTxt;
            case 'base_price':
                return $d->base_price ?? null ? 'Rs. ' . number_format((float) $d->base_price) : null;
        }
        return null;
    };

    $logo = $logoData($tournament->logo, 36, 36);
    $initials = strtoupper(substr(Str::before($tournament->short_code, '-'), 0, 3));

    // Split into rows of 3 cards
    $rows = $players->values()->chunk($columns)->values();
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $tournament->name }} - Players List</title>
    <style>
        /* Remove page margins entirely so DomPDF calculates exact heights */
        @page {
            margin: 0;
        }

        body,
        h1,
        p,
        div,
        td,
        span,
        strong {
            font-family: Helvetica, Arial, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            color: #111827;
            font-size: {{ $fs }}pt;
            /* We pad the body instead of @page to control edge spaces safely */
            padding: 20pt 24pt 34pt 24pt;
        }

        /* ---------- Header ---------- */
        .header {
            background: #111111;
            border-radius: 6pt;
            margin-bottom: 6pt;
            page-break-inside: avoid;
            page-break-after: avoid;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
            padding: 8pt 12pt;
        }

        .logo-box {
            width: 40pt;
            height: 40pt;
            background: #ffffff;
            border-radius: 6pt;
        }

        .logo-initials {
            font-size: 12pt;
            font-weight: bold;
            color: #be212a;
        }

        .badge {
            display: inline-block;
            background: #be212a;
            color: #ffffff;
            font-size: 7pt;
            font-weight: bold;
            padding: 1.5pt 6pt;
            border-radius: 3pt;
        }

        .title {
            font-size: 14pt;
            font-weight: bold;
            color: #ffffff;
            margin: 3pt 0 2pt 0;
        }

        .subtitle {
            font-size: 7.5pt;
            color: #9ca3af;
            margin: 0;
        }

        .summary {
            text-align: right;
            width: 70pt;
        }

        .summary-num {
            font-size: 18pt;
            font-weight: bold;
            color: #ffffff;
        }

        .summary-lbl {
            font-size: 7pt;
            color: #be212a;
            font-weight: bold;
        }

        /* ---------- Grid ---------- */
        .grid {
            border-collapse: separate;
            border-spacing: {{ $gap }}pt;
            table-layout: fixed;
            width: {{ $pageWidth + $gap }}pt;
            margin-left: -{{ $gap }}pt;
            /* Offset the first cell's left gap */
        }

        .grid tr {
            page-break-inside: avoid;
            /* Force exact rows */
        }

        .grid td.slot {
            vertical-align: top;
            width: {{ $cardW }}pt;
            padding: 0;
        }

        /* ---------- Card ---------- */
        .card {
            width: {{ $cardW }}pt;
            height: {{ $cardH }}pt;
            /* Exact fixed height */
            border: 1pt solid #d1d5db;
            border-radius: 5pt;
            background: #ffffff;
            page-break-inside: avoid;
            overflow: hidden;
            /* Prevent inner content from breaking the size */
        }

        .topbar {
            height: 3pt;
            background: #be212a;
            border-radius: 4pt 4pt 0 0;
        }

        .inner {
            border-collapse: collapse;
            width: 100%;
        }

        .inner td {
            vertical-align: top;
        }

        .inner td.ph {
            width: {{ $photoCellW }}pt;
            padding: 3pt 0 3pt 4pt;
        }

        .inner td.info {
            padding: 3pt 4pt 3pt 6pt;
        }

        .photo-img {
            display: block;
            width: {{ $photoW }}pt;
            height: {{ $photoH }}pt;
            border: 0.5pt solid #d1d5db;
        }

        .photo-empty {
            width: {{ $photoW }}pt;
            height: {{ $photoH }}pt;
            line-height: {{ $photoH }}pt;
            background: #f3f4f6;
            border: 0.5pt solid #d1d5db;
            text-align: center;
            font-size: 18pt;
            font-weight: bold;
            color: #9ca3af;
        }

        /* --- Text Constraints --- */
        .nm {
            font-weight: bold;
            color: #111111;
            height: {{ $lineH }}pt;
            line-height: {{ $lineH }}pt;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: {{ $infoW }}pt;
        }

        .no {
            font-weight: bold;
            color: #be212a;
            font-size: {{ $fs }}pt;
            height: {{ $lineH }}pt;
            line-height: {{ $lineH }}pt;
            border-bottom: 0.5pt solid #e5e7eb;
            margin-bottom: 1pt;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: {{ $infoW }}pt;
        }

        .ln {
            font-size: {{ $fs }}pt;
            height: {{ $lineH }}pt;
            line-height: {{ $lineH }}pt;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: {{ $infoW }}pt;
        }

        .lb {
            color: #6b7280;
        }

        .vl {
            color: #111111;
            font-weight: bold;
        }

        .bl-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }

        .bl-table td {
            height: {{ $lineH }}pt;
            vertical-align: bottom;
            padding: 0;
            font-size: {{ $fs }}pt;
            font-weight: bold;
        }

        .bl-label {
            width: 12pt;
        }

        .bl-line {
            border-bottom: 0.75pt solid #111111;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 40pt 0;
            font-size: 11pt;
        }
    </style>
</head>

<body>

    {{-- ===== Header ===== --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 40pt;">
                    @if ($logo)
                        <table class="logo-box" cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="text-align:center; vertical-align:middle;">
                                    <img src="{{ $logo['src'] }}"
                                        style="width: {{ $logo['w'] }}pt; height: {{ $logo['h'] }}pt;">
                                </td>
                            </tr>
                        </table>
                    @else
                        <table class="logo-box" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="logo-initials" style="text-align:center; vertical-align:middle;">
                                    {{ $initials }}</td>
                            </tr>
                        </table>
                    @endif
                </td>
                <td>
                    <span class="badge"># {{ $tournament->short_code }}</span>
                    <div class="title">{{ $tournament->name }}</div>
                    <p class="subtitle">
                        VENUE: {{ strtoupper($tournament->venue ?? 'N/A') }}
                    </p>
                </td>
                <td class="summary">
                    <div class="summary-num">{{ $players->count() }}</div>
                    <div class="summary-lbl">PLAYERS</div>
                </td>
            </tr>
        </table>
    </div>

    @if ($players->isEmpty())
        <div class="empty">No players found for this tournament.</div>
    @endif

    {{-- ===== Player Cards ===== --}}
    @if ($players->isNotEmpty())
        <table class="grid">
            @foreach ($rows as $chunk)
                <tr>
                    @foreach ($chunk as $player)
                        @php
                            $photo = $photoData($player->photo, $photoW, $photoH);
                            $nameLen = mb_strlen($player->name);
                            if ($nameLen > 24) {
                                $nameSize = '8pt';
                            } elseif ($nameLen > 19) {
                                $nameSize = '8.5pt';
                            } elseif ($nameLen > 15) {
                                $nameSize = '9.5pt';
                            } else {
                                $nameSize = '11pt';
                            }
                            $nameInitials =
                                strtoupper(mb_substr($player->name, 0, 1)) .
                                strtoupper(mb_substr(trim(Str::after($player->name, ' ')) ?: '', 0, 1));
                        @endphp
                        <td class="slot">
                            <div class="card">
                                <div class="topbar"></div>
                                <table class="inner" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="ph">
                                            @if ($photo)
                                                <img class="photo-img" src="{{ $photo }}">
                                            @else
                                                <div class="photo-empty">{{ $nameInitials ?: '?' }}</div>
                                            @endif
                                        </td>
                                        <td class="info">
                                            <div class="nm" style="font-size: {{ $nameSize }};">
                                                {{ Str::limit($player->name, 24, '..') }}</div>
                                            <div class="no">NO: {{ $player->player_number ?? 'N/A' }}</div>

                                            @foreach ($layout as $key)
                                                <div class="ln"><span
                                                        class="lb">{{ $labels[$key] ?? ucfirst($key) . ':' }}</span>
                                                    <span class="vl">{{ $resolve($key, $player) ?: '-' }}</span>
                                                </div>
                                            @endforeach

                                            @foreach ($blanks as $b)
                                                <table class="bl-table">
                                                    <tr>
                                                        <td class="bl-label">{{ $b }}:</td>
                                                        <td class="bl-line"></td>
                                                    </tr>
                                                </table>
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    @endforeach

                    {{-- Keep every slot the same width when the last row is not full --}}
                    @for ($k = $chunk->count(); $k < $columns; $k++)
                        <td class="slot"></td>
                    @endfor
                </tr>
            @endforeach
        </table>
    @endif

    {{-- Footer with page numbers --}}
    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->get_font("helvetica", "normal");
            $label = {!! json_encode($tournament->name . ' - Players List') !!};
            $pdf->page_text(24, $pdf->get_height() - 24, $label, $font, 8, array(0.42, 0.45, 0.5));
            $pdf->page_text($pdf->get_width() - 90, $pdf->get_height() - 24, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0.42, 0.45, 0.5));
        }
    </script>
</body>

</html>
