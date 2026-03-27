// api/posts.js — Vercel Serverless Function
// Returns all published posts from Notion database as JSON

const { Client } = require('@notionhq/client');

const notion = new Client({ auth: process.env.NOTION_TOKEN });

// Map Notion category select → internal slug
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

module.exports = async function handler(req, res) {
  if (req.method === 'OPTIONS') { res.status(200).end(); return; }

  try {
    const dbId = process.env.NOTION_DATABASE_ID;
    if (!dbId) throw new Error('NOTION_DATABASE_ID not set');

    const response = await notion.databases.query({
      database_id: dbId,
      filter: {
        property: 'status',
        select: { equals: 'Published' },
      },
      sorts: [{ property: 'date', direction: 'descending' }],
      page_size: 50,
    });

    const posts = response.results.map(page => {
      const p = page.properties;
      const catName = getText(p.category);
      return {
        id:       page.id,
        title:    getText(p.title),
        category: CAT_SLUG[catName] || 'deep-dive',
        catLabel: catName || 'Deep Dive Blog',
        excerpt:  getText(p.excerpt),
        cover:    getText(p.cover),
        date:     getText(p.date),
        author:   getText(p.author) || 'Sam Kim',
      };
    });

    res.status(200).json({ posts });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: err.message });
  }
};
