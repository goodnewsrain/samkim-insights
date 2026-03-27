// api/post.js — Vercel Serverless Function
// Returns single post content (Notion blocks → HTML)

const { Client } = require('@notionhq/client');

const notion = new Client({ auth: process.env.NOTION_TOKEN });

const CAT_SLUG = {
  'Special Report':          'special-report',
  'Spotlight':               'spotlight',
  'Case Studies & Insights': 'case-studies',
  'Deep Dive Blog':          'deep-dive',
};

function getText(prop) {
  if (!prop) return '';
  if (prop.type === 'title')     return prop.title.map(t => t.plain_text).join('');
  if (prop.type === 'rich_text') return prop.rich_text.map(t => t.plain_text).join('');
  if (prop.type === 'select')    return prop.select?.name || '';
  if (prop.type === 'url')       return prop.url || '';
  if (prop.type === 'date')      return prop.date?.start || '';
  return '';
}

// Convert rich text array → HTML string (bold, italic, links)
function richToHtml(richText) {
  return (richText || []).map(t => {
    let html = t.plain_text
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;');
    if (t.annotations?.bold)          html = `<strong>${html}</strong>`;
    if (t.annotations?.italic)        html = `<em>${html}</em>`;
    if (t.annotations?.strikethrough) html = `<del>${html}</del>`;
    if (t.annotations?.code)          html = `<code>${html}</code>`;
    if (t.href)                        html = `<a href="${t.href}" target="_blank" rel="noopener">${html}</a>`;
    return html;
  }).join('');
}

// Convert Notion blocks → HTML
function blocksToHtml(blocks) {
  let html = '';
  let inList = null;

  for (const block of blocks) {
    const type = block.type;

    // Close open list if needed
    if (inList && type !== 'bulleted_list_item' && type !== 'numbered_list_item') {
      html += inList === 'ul' ? '</ul>' : '</ol>';
      inList = null;
    }

    if (type === 'paragraph') {
      const text = richToHtml(block.paragraph.rich_text);
      html += text ? `<p>${text}</p>` : '<br>';

    } else if (type === 'heading_1') {
      html += `<h2>${richToHtml(block.heading_1.rich_text)}</h2>`;

    } else if (type === 'heading_2') {
      html += `<h2>${richToHtml(block.heading_2.rich_text)}</h2>`;

    } else if (type === 'heading_3') {
      html += `<h3>${richToHtml(block.heading_3.rich_text)}</h3>`;

    } else if (type === 'bulleted_list_item') {
      if (inList !== 'ul') { html += '<ul>'; inList = 'ul'; }
      html += `<li>${richToHtml(block.bulleted_list_item.rich_text)}</li>`;

    } else if (type === 'numbered_list_item') {
      if (inList !== 'ol') { html += '<ol>'; inList = 'ol'; }
      html += `<li>${richToHtml(block.numbered_list_item.rich_text)}</li>`;

    } else if (type === 'quote') {
      html += `<blockquote>${richToHtml(block.quote.rich_text)}</blockquote>`;

    } else if (type === 'callout') {
      const emoji = block.callout.icon?.emoji || '';
      html += `<blockquote>${emoji} ${richToHtml(block.callout.rich_text)}</blockquote>`;

    } else if (type === 'code') {
      const code = block.code.rich_text.map(t => t.plain_text).join('');
      html += `<pre><code>${code.replace(/</g,'&lt;')}</code></pre>`;

    } else if (type === 'image') {
      const url = block.image.type === 'external'
        ? block.image.external.url
        : block.image.file.url;
      const caption = richToHtml(block.image.caption);
      html += `<figure><img src="${url}" alt="${caption || ''}"><figcaption>${caption}</figcaption></figure>`;

    } else if (type === 'divider') {
      html += '<hr>';

    } else if (type === 'video') {
      const url = block.video.type === 'external' ? block.video.external.url : '';
      if (url.includes('youtube') || url.includes('youtu.be')) {
        const id = url.match(/(?:v=|youtu\.be\/)([^&?]+)/)?.[1];
        if (id) html += `<div class="video-embed"><iframe src="https://www.youtube.com/embed/${id}" frameborder="0" allowfullscreen></iframe></div>`;
      }
    }
  }

  if (inList === 'ul') html += '</ul>';
  if (inList === 'ol') html += '</ol>';

  return html;
}

module.exports = async function handler(req, res) {
  if (req.method === 'OPTIONS') { res.status(200).end(); return; }

  const { id } = req.query;
  if (!id) { res.status(400).json({ error: 'Missing post id' }); return; }

  try {
    // Get page properties
    const page = await notion.pages.retrieve({ page_id: id });
    const p = page.properties;
    const catName = getText(p.category);

    // Get page blocks (content)
    const blocksResp = await notion.blocks.children.list({ block_id: id, page_size: 100 });
    const contentHtml = blocksToHtml(blocksResp.results);

    res.status(200).json({
      post: {
        id:          page.id,
        title:       getText(p.title),
        category:    CAT_SLUG[catName] || 'deep-dive',
        catLabel:    catName || 'Deep Dive Blog',
        excerpt:     getText(p.excerpt),
        cover:       getText(p.cover),
        date:        getText(p.date),
        author:      getText(p.author) || 'Sam Kim',
        contentHtml,
      }
    });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: err.message });
  }
};
