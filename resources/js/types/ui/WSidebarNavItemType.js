function WSidebarNavItemType ({ text, link, faIcon, iconGradientClass, children }) {
  this.text = text || 'Link'
  this.link = link || '#'
  this.faIcon = faIcon || 'newspaper'
  this.iconGradientClass = iconGradientClass || 'gradient-pink'
  this.children = children || []
}

export default WSidebarNavItemType
