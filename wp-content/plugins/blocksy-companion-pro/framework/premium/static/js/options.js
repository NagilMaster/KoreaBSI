import { createRoot, createElement, Fragment } from '@wordpress/element'
import { Fill } from '@wordpress/components'
import HooksSelect from './options/HooksSelect'
import IconPicker from './options/IconPicker'
import BlocksyPosition from './options/BlocksyPosition'
import MultipleLocationsSelect from './options/MultipleLocationsSelect'
import PreviewedPostsSelect from './options/PreviewedPostsSelect'

import { onDocumentLoaded } from 'blocksy-options'

import { addFilter } from '@wordpress/hooks'

import ctEvents from 'ct-events'

import CreateHeader from './header/CreateHeader'
import CloneItem from './header/CloneItem'
import PanelsManager from './footer/PanelsManager'

import CloneFooterItem from './footer/CloneItem'

import CreateHook from './hooks/CreateHook'
import { mountCodeEditor } from './hooks/CodeEditor'
import { mountHooksSwitch } from './hooks/hooksSwitch'
import './blocks/ContentBlock'

import { mountDynamicFontsIntegration } from './typography/dynamic-fonts'
import { mountVideoMetaOptions } from './media-video'

addFilter('blocksy.header.available-sections', 'blocksy', (value, sections) =>
	sections.filter(
		({ id }) =>
			id !== 'type-2' && id !== 'type-3' && id !== 'ct-custom-transparent'
	)
)

addFilter('greenshift.editor.inlineCssLoading', 'blocksy', (current) => {
	if (
		document.body.className.indexOf('post-type-ct') > -1 ||
		document.body.className.indexOf('post-type-blc') > -1
	) {
		return false
	}

	return current
})

mountDynamicFontsIntegration()

onDocumentLoaded(() => {
	mountCodeEditor()
	mountHooksSwitch()

	mountVideoMetaOptions()

	const createHookEl = document.querySelector(
		'[href*="post-new.php?post_type=ct_content_block"].page-title-action'
	)

	if (!document.body.classList.contains('post-type-ct_content_block')) {
		return
	}

	if (createHookEl) {
		const div = document.createElement('div')
		document.body.appendChild(div)

		const root = createRoot(div)
		root.render(<CreateHook />)
	}
})

ctEvents.on('blocksy:options:before-option', (args) => {
	if (!args.option) {
		return
	}

	if (args.option.type === 'ct-header-builder') {
		let prevHeaderBuilder = args.content

		args.content = (
			<Fragment>
				{prevHeaderBuilder}

				<Fill name="PlacementsBuilderPanelsManagerAfter">
					{() => (
						<Fragment>
							<CreateHeader />
						</Fragment>
					)}
				</Fill>

				{Array(30)
					.fill(5)
					.map((_, index) => (
						<Fill
							key={index}
							name={`PlacementsBuilderSidebarItem_${index}`}>
							{(props) => <CloneItem {...props} />}
						</Fill>
					))}
			</Fragment>
		)
	}

	if (args.option.type === 'ct-footer-builder') {
		let prevFooterBuilder = args.content

		args.content = (
			<Fragment>
				{prevFooterBuilder}

				<Fill name="ColumnsBuilderPanelsManager">
					<PanelsManager />
				</Fill>

				{Array(30)
					.fill(5)
					.map((_, index) => (
						<Fill
							key={index}
							name={`ColumnsBuilderSidebarItem_${index}`}>
							{(props) => <CloneFooterItem {...props} />}
						</Fill>
					))}
			</Fragment>
		)
	}
})

ctEvents.on('blocksy:options:register', (opts) => {
	opts['blocksy-hooks-select'] = HooksSelect
	opts['icon-picker'] = IconPicker
	opts['blocksy-multiple-locations-select'] = MultipleLocationsSelect
	opts['blocksy-position'] = BlocksyPosition
	opts['blocksy-previewed-post'] = PreviewedPostsSelect
})
