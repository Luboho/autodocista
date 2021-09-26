module.exports = {
  future: {
    // removeDeprecatedGapUtilities: true,
    // purgeLayersByDefault: true,
  },
  purge: [],
  theme: {
    
    borderWidth: {
      '0.5': '0.5px',
      '1': '1px',
      '2': '2px',
      '4': '4px',
      '12': '12px'
    },
    minWidth: {
      'xxs': '378px'
    },
    maxWidth: {
      '1024': '1024px',
      '7xl': '1800px'
    },
    maxHeight: {
      '250px': '250px',
      '400px': '400px'
    },
    fontSize: {
      'xs': '.75rem',
      'sm': '.875rem',
      'tiny': '.875rem',
      'base': '1rem',
      'lg': '1.125rem',
      'xl': '1.25rem',
      '2xl': '1.5rem',
      '3xl': '1.875rem',
      '4xl': '2.25rem',
      '5xl': '3rem',
      '6xl': '4rem',
      '7xl': '5rem',
    },
    extend: {
      animation: {
        'spin-slow': 'spin 3s linear infinite'
       },
      spacing: {
        '0.5': '0.125rem',
        '1': '0.25rem',
        '1.5': '0.375rem',
        '2': '0.5rem',
        '2.5': '0.675rem',
        '3': '0.75rem',
        '3.5': '0.875rem',
        '4': '1rem',
        '5': '1.25rem',
        '6': '1.5rem',
        '7': '1.75rem',
        '8': '2rem',
        '9': '2.25rem',
        '9.5': '2.375rem',
        '10': '2.5rem',
        '10.5': '2.625rem',
        '11': '2.75rem',
        '12': '3rem',
        '14': '3.5rem',
        '16': '4rem',
        '20': '5rem',
        '24': '6rem',
        '26': '6.5rem',
        '28': '7rem',
        '32': '8rem',
        '36': '9rem',
        '40': '10rem',
        '44': '11rem',
        '48': '12rem',
        '52': '13rem',
        '56': '14rem',
        '60': '15rem',
        '64': '16rem',
        '72': '18rem',
        '80': '20rem',
        '96': '24rem',
        '100': '25rem',
        '101': '25.25rem',
        '101.5': '25.35rem',
        '102': '25.50rem',
        '102.5': '25.65rem'
      },
      colors: {
        gray: {
          '50': '#f4f4f4', 
          '100': '#e9e9ea', 
          '200': '#c9c9ca', 
          '300': '#a9a9aa', 
          '400': '#68686a', 
          '500': '#27272a', 
          '600': '#232326', 
          '700': '#1d1d20', 
          '800': '#171719', 
          '900': '#131315'
        },
        gold: {
            '50': '#fffdf6', 
            '100': '#fffced', 
            '200': '#fff7d1', 
            '300': '#fef3b5', 
            '400': '#fee97e', 
            '500': '#fde047', 
            '600': '#e4ca40', 
            '700': '#bea835', 
            '800': '#98862b', 
            '900': '#7c6e23'
        },
        warmGray: {
          '300': '#D6D3D1',
          '400': '#A8A29E'
        },
        coolGray: {
          '50': '#F9FAFB', 
          '100': '#F3F4F6', 
          '200': '#E5E7EB', 
          '300': '#D1D5DB', 
          '400': '#9CA3AF', 
          '500': '#6B7280', 
          '600': '#4B5563', 
          '700': '#374151', 
          '800': '#1F2937', 
          '900': '#111827'
        },
        blueGray: {
          '50': '#F8FAFC',
          '100': '#F1F5F9',
          '200': '#E2E8F0',
          '300': '#CBD5E1',
          '400': '#94A3B8',
          '500': '#64748B',
          '600': '#475569',
          '700': '#334155',
          '800': '#1E293B',
          '900': '#0F172A'
        }
      },
    },
    
  },
  variants: {
    backgroundColor: ['even', 'odd', 'active', 'hover', 'focus', 'responsive'],
    textColor: ['responsive', 'focus', 'active','hover'],
    scale: ['responsive', 'focus', 'active', 'hover'],
    translate: ['responsive', 'focus', 'active',],
  },
  plugins: [],
}
